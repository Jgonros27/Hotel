<?php

namespace App\Http\Controllers;

use App\DataTables\ReservaSalonsDataTable;
use App\Http\Requests\ReservaSalonRequest;
use App\Mail\ReservaSalonActualizarMail;
use App\Mail\ReservaSalonBorrarMail;
use App\Mail\ReservaSalonMail;
use App\Models\ReservaSalon;
use App\Models\Salon;
use App\Models\TipoCabana;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Stripe\Exception\InvalidRequestException;

class ReservaSalonController extends Controller
{
    // Método para mostrar el índice de las reservas de salones
    public function index(ReservaSalonsDataTable $dataTable, Request $request)
    {
        // Obtener todos los usuarios y salones
        $usuarios = User::select('id', 'email', "name")->get();
        $salons = Salon::select('id', 'nombre')->get();

        // Obtener el ID del usuario y del salón desde la solicitud
        $usuarioId = $request->input('usuarioId');
        $salonId = $request->input('salonId');

        // Renderizar la vista del índice de reservas de salones con los datos obtenidos
        return $dataTable->render('admin.reservaSalons.index', ['salonId' => $salonId, 'usuarioId' => $usuarioId, 'usuarios' => $usuarios, 'salons' => $salons]);
    }

    // Método para eliminar una reserva de salón
    public function destroy($id)
    {
        // Encontrar la reserva de salón por su ID
        $reservaSalon = ReservaSalon::find($id);

        // Obtener el ID del usuario asociado con la reserva
        $usuarioId = DB::table('reserva_salons')
            ->select('id_usuario')
            ->where('id', '=', $id)
            ->get()[0]->id_usuario;

        // Obtener la información del usuario
        $usuario = DB::table('users')
            ->select('email', 'name')
            ->where('id', '=', $usuarioId)
            ->get()[0];

        // Eliminar la reserva de salón
        $reservaSalon->delete();

        // Enviar un correo electrónico al usuario informando sobre la cancelación de la reserva
        Mail::to($usuario->email)->send(new ReservaSalonBorrarMail([
            'nombre' => $usuario->name,
        ]));

        // Redirigir según el tipo de usuario que realiza la acción
        if (auth()->user()->admin) {
            return redirect('/salons/reserva')->with('success', 'La reserva ha sido borrada');
        } else {
            return Redirect::back()->with('cancelada', __('mail.lamentamos') . '. ' . __('mail.noDevuelto2'));
        }
    }

    // Método para mostrar el formulario de creación de una nueva reserva de salón
    public function create()
    {
        // Obtener todos los usuarios y salones
        $usuarios = User::select('id', 'email')->get();
        $salons = Salon::select('id', 'nombre')->get();

        // Renderizar la vista del formulario de creación de reserva de salón con los datos obtenidos
        return view('admin.reservaSalons.create', ['usuarios' => $usuarios, 'salons' => $salons]);
    }


    public function store(ReservaSalonRequest $request)
    {
        // Verificar si ya existe una reserva para el salón en la fecha y horario especificados
        $existeReserva = ReservaSalon::select('id')
            ->where('id_salon', $request->salon)
            ->where('fecha_evento', $request->fechaEvento)
            ->where('hora_inicio', '<', $request->horaFin)
            ->where('hora_fin', '>', $request->horaInicio)
            ->get();

        if ($existeReserva->isEmpty()) {
            // Si no existe reserva, proceder con la creación de la reserva
            $data = [
                'id_usuario' => $request->usuario,
                'id_salon' => $request->salon,
                'fecha_evento' => $request->fechaEvento,
                'hora_inicio' => $request->horaInicio,
                'hora_fin' => $request->horaFin,
                'tipo_evento' => $request->tipoEvento,
                'mensaje' => $request->mensaje
            ];

            // Calcular el precio de la reserva en base al precio por hora del salón y el número de horas reservadas
            $precio_hora = Salon::select('precio_hora')->where('id', $request->salon)->first()->precio_hora;
            $numeroDeHoras = ReservaSalon::calcularHorasEntreDosHoras($request->horaInicio, $request->horaFin);
            $precio = $numeroDeHoras * $precio_hora;
            $data['precio_final'] = number_format($precio, 2);

            // Obtener el nombre del salón para incluirlo en el correo electrónico
            $salonNombre = Salon::select('nombre')->where('id', $request->salon)->first()->nombre;

            if (auth()->user()->admin) {
                // Si el usuario es un administrador, crear la reserva y enviar correo de verificación al cliente
                $reserva = ReservaSalon::create($data);
                $usuario = User::select('name', 'email')->where('id', $request->usuario)->first();
                Mail::to($usuario->email)->send(new ReservaSalonMail([
                    'nombre' => $usuario->name,
                    'salon' => $salonNombre,
                    'fechaEvento' => $request->fechaEvento,
                    'horaInicio' => $request->horaInicio,
                    'horaFin' => $request->horaFin,
                    'mensaje' => $request->mensaje,
                    'reservaId' => $reserva->id
                ]));

                // Eliminar el archivo de factura generado previamente (si existe)
                unlink(storage_path('app/reservaSalons/factura' . $reserva->id . '.pdf'));

                return redirect('/salons/reserva')->with('success', 'La reserva ha sido creada, se le ha enviado un correo de verificación al cliente');
            } else {
                // Si el usuario no es un administrador, mostrar la página de pago con la información de la reserva
                $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
                $salons = Salon::select('id', 'nombre')->get();
                return view('hotel.pago', [
                    'data' => $data,
                    'salones' => $salons,
                    'cabanas' => $tipoCabanas,
                    'salon' => $salonNombre,
                    'precioHora' => $precio_hora
                ]);
            }
        } else {
            // Si ya existe una reserva para el salón en la fecha y horario seleccionados, mostrar un mensaje de error
            if (auth()->user()->admin) {
                return redirect('/salons/reserva/create')->with('error', 'No hay salones disponibles para la fecha y horas seleccionadas.');
            } else {
                return Redirect::back()->with('error', __('reservas.salonesDisp'));
            }
        }
    }


    public function pagado(Request $request)
    {
        // Iniciar una transacción en la base de datos
        DB::beginTransaction();
        try {
            // Decodificar los datos JSON enviados desde el formulario
            $data = json_decode($request->input('data'), true);

            // Establecer la clave de la API de Stripe
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Obtener el monto del pago y la dirección de correo electrónico del formulario
            $amount = intval($data['precio_final'] * 100);
            $email = $request->input('email');

            // Crear un nuevo cliente en Stripe
            $customer = \Stripe\Customer::create([
                'email' => $email,
                'source' => $request->input('stripeToken'),
            ]);

            // Crear un nuevo cargo en Stripe
            $charge = \Stripe\Charge::create([
                'customer' => $customer->id,
                'amount' => $amount,
                'currency' => 'eur',
            ]);

            // Si el cargo se realiza con éxito
            if ($charge->status) {
                // Crear la reserva del salón en la base de datos
                $reserva = ReservaSalon::create($data);

                // Confirmar la transacción en la base de datos
                DB::commit();

                // Obtener información del usuario para enviar el correo electrónico de confirmación
                $usuario = User::select('name', 'email')->where('id', $data['id_usuario'])->get()[0];

                // Enviar correo electrónico de confirmación de la reserva al usuario
                Mail::to($usuario->email)->send(new ReservaSalonMail([
                    'nombre' => $usuario->name,
                    'salon' => $request->input('salon'),
                    'fechaEvento' => $data['fecha_evento'],
                    'horaInicio' => $data['hora_inicio'],
                    'horaFin' => $data['hora_fin'],
                    'mensaje' => $data['mensaje'],
                    'reservaId' => $reserva->id
                ]));

                // Eliminar el archivo de factura generado previamente (si existe)
                unlink(storage_path('app/reservaSalons/factura' . $reserva->id . '.pdf'));

                // Obtener información adicional para mostrar en la página de reserva completada
                $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
                $salons = Salon::select('id', 'nombre')->get();

                // Renderizar la vista de reserva completada con los datos necesarios
                return view('hotel.reservaCompletada', [
                    'reserva' => $reserva,
                    'salones' => $salons,
                    'cabanas' => $tipoCabanas,
                    'salon' => $request->input('salon'),
                    'precioHora' => $request->input('precioHora')
                ]);
            }
        } catch (InvalidRequestException $e) {
            // Si hay un error de solicitud inválida, registrar el error y redirigir a la página de inicio
            Log::error("Error token", [$e]);
            return redirect('/home');
        } catch (Exception $e) {
            // Si hay una excepción general, revertir la transacción en la base de datos, registrar el error y redirigir a la página de inicio
            DB::rollBack();
            Log::error("Error token", [$e]);
            return redirect('/home')->with('fallo', __('inicio.error'));
        }
    }


    public function edit($id)
    {
        // Obtener todos los usuarios y salones disponibles
        $usuarios = User::select('id', 'email')->get();
        $salons = Salon::select('id', 'nombre')->get();

        // Encontrar la reserva del salón por su ID
        $reservaSalon = ReservaSalon::find($id);

        // Renderizar la vista de edición con la reserva del salón y los datos necesarios
        return view('admin.reservaSalons.edit', ['reservaSalon' => $reservaSalon, 'usuarios' => $usuarios, 'salons' => $salons]);
    }

    public function update(ReservaSalonRequest $request, $id)
    {
        // Verificar si ya existe una reserva para el salón en la fecha y horario especificados
        $existeReserva = ReservaSalon::select('id')
            ->where('id_salon', $request->salon)
            ->where('fecha_evento', $request->fechaEvento)
            ->where('hora_inicio', '>', $request->horaInicio)
            ->where('hora_fin', '<', $request->horaFin)
            ->get();

        if ($existeReserva->isEmpty()) {
            // Si no existe reserva, proceder con la actualización de la reserva existente
            $data = [];
            $reservaSalon = ReservaSalon::find($id);
            $data['id_usuario'] = $request->usuario;
            $data['id_salon'] = $request->salon;
            $data['fecha_evento'] = $request->fechaEvento;
            $data['hora_inicio'] = $request->horaInicio;
            $data['hora_fin'] = $request->horaFin;
            $data['tipo_evento'] = $request->tipoEvento;
            $data['mensaje'] = $request->mensaje;

            // Calcular el precio de la reserva en base al precio por hora del salón y el número de horas reservadas
            $precio_hora = Salon::select('precio_hora')->where('id', $request->salon)->first()->precio_hora;
            $numeroDeHoras = ReservaSalon::calcularHorasEntreDosHoras($request->horaInicio, $request->horaFin);
            $precio = $numeroDeHoras * $precio_hora;
            $data['precio_final'] = number_format($precio, 2);

            // Actualizar la reserva del salón en la base de datos con los nuevos datos
            $reservaSalon->update($data);

            // Obtener información adicional para incluir en el correo electrónico de actualización
            $salon = Salon::select('nombre')->where('id', $request->salon)->first()->nombre;
            $usuario = User::select('name', 'email')->where('id', $request->usuario)->first();

            // Enviar correo electrónico de actualización de la reserva al usuario
            Mail::to($usuario->email)->send(new ReservaSalonActualizarMail([
                'nombre' => $usuario->name,
                'salon' => $salon,
                'fechaEvento' => $request->fechaEvento,
                'horaInicio' => $request->horaInicio,
                'horaFin' => $request->horaFin,
                'mensaje' => $request->mensaje,
                'reservaId' => $reservaSalon->id
            ]));

            // Eliminar el archivo de factura generado previamente (si existe)
            unlink(storage_path('app/reservaSalons/factura' . $reservaSalon->id . '.pdf'));

            // Redirigir al usuario de vuelta a la página de reservas de salones con un mensaje de éxito
            return redirect('/salons/reserva')->with('success', 'La reserva ha sido actualizada');
        } else {
            // Si ya existe una reserva para el salón en la fecha y horario seleccionados, mostrar un mensaje de error
            return redirect('/salons/reserva/create')->with('error', __('reservas.salonesDisp'));
        }
    }


    public function facturaPdf(Request $request)
    {
        // Obtener la reserva del salón utilizando el ID proporcionado en la solicitud
        $reservaSalon = ReservaSalon::find($request->input('idReservaSalon'));

        // Generar el HTML para la factura utilizando la vista correspondiente
        $html = view('admin.reservaSalons.facturaPdf', ['reservaSalon' => $reservaSalon])->render();

        // Crear un archivo temporal para almacenar el HTML generado
        $tempHtmlFile = tempnam(sys_get_temp_dir(), 'report_');
        File::put($tempHtmlFile, $html);

        // Definir la ruta del archivo PDF donde se guardará la factura
        $pdfPath = storage_path('app/reservaSalons/factura' . $reservaSalon->id . '.pdf');

        // Generar el PDF a partir del HTML y guardarlo en la ruta especificada
        SnappyPdf::loadHTML($html)->save($pdfPath);

        // Devolver el archivo PDF como respuesta y eliminarlo después de ser enviado
        return response()->file($pdfPath)->deleteFileAfterSend(true);
    }

    public function disponibilidad(Request $request)
    {
        // Validar los datos de entrada: fecha del evento, hora de inicio y hora de fin
        $request->validate([
            'fechaEvento' => 'required|date',
            'horaInicio' => 'required',
            'horaFin' => 'required|after:horaInicio',
        ]);

        // Obtener la fecha del evento, hora de inicio y hora de fin desde la solicitud
        $fechaEvento = $request->input('fechaEvento');
        $horaInicio = $request->input('horaInicio');
        $horaFin = $request->input('horaFin');

        // Obtener todos los salones disponibles
        $salones = Salon::all();
        $salonesDisponibles = [];

        // Verificar la disponibilidad de cada salón para el evento
        foreach ($salones as $salon) {
            $existe = ReservaSalon::where('id_salon', $salon->id)
                ->where('hora_inicio', '<', $request->horaFin)
                ->where('hora_fin', '>', $request->horaInicio)
                ->where('fecha_evento', $request->fechaEvento)
                ->count();
            if ($existe == 0) {
                array_push($salonesDisponibles, $salon->nombre);
            }
        }

        // Renderizar la vista de disponibilidad con los salones disponibles y los detalles del evento
        return view('admin.reservaSalons.disponibilidad', compact('salonesDisponibles', 'fechaEvento', 'horaInicio', 'horaFin'));
    }
}
