<?php

namespace App\Http\Controllers;

use App\DataTables\ReservaCabanasDataTable;
use App\Http\Requests\ReservaCabanaRequest;
use App\Mail\ReservaCabanaActualizarMail;
use App\Mail\ReservaCabanaBorrarMail;
use App\Mail\ReservaCabanaMail;
use App\Models\Cabana;
use App\Models\ReservaCabana;
use App\Models\Salon;
use App\Models\TipoCabana;
use App\Models\User;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Stripe\Exception\InvalidRequestException;

use function Laravel\Prompts\select;

class ReservaCabanaController extends Controller
{
    public function index(ReservaCabanasDataTable $dataTable, Request $request)
    {
        // Obtener todos los tipos de cabaña para los filtros
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();

        // Obtener todos los usuarios para los filtros
        $usuarios = User::select('id', 'email', 'name')->get();

        // Obtener el ID del tipo de cabaña seleccionado (si se proporciona)
        $tipoCabanaId = $request->input('tipoCabanaId');

        // Obtener el ID del usuario seleccionado (si se proporciona)
        $usuarioId = $request->input('usuarioId');

        // Renderizar la vista de las reservas de cabañas con los datos obtenidos
        return $dataTable->render('admin.reservaCabanas.index', [
            'tipoCabanas' => $tipoCabanas,
            'usuarios' => $usuarios,
            'usuarioId' => $usuarioId,
            'tipoCabanaId' => $tipoCabanaId
        ]);
    }


    public function destroy($id)
    {
        // Encontrar la reserva de cabaña por su ID
        $reservaCabana = ReservaCabana::find($id);

        // Obtener la fecha de entrada de la reserva de cabaña
        $fechaEntrada = $reservaCabana->fecha_entrada;

        // Obtener los días de cancelación del tipo de cabaña asociado a la reserva
        $tipoCabanaDiasCancelacion = DB::table('tipo_cabanas as tc')
            ->select('tc.dias_cancelacion')
            ->join('cabanas as c', 'c.id_tipo_cabana', '=', 'tc.id')
            ->join('reserva_cabanas as rc', 'c.id', '=', 'rc.id_cabana')
            ->where('rc.id', $id)
            ->get()[0]->dias_cancelacion;

        // Obtener el ID del usuario asociado a la reserva
        $usuarioId = DB::table('reserva_cabanas')
            ->select('id_usuario')
            ->where('id', '=', $id)
            ->get()[0]->id_usuario;

        // Obtener la información del usuario asociado a la reserva
        $usuario = DB::table('users')
            ->select('email', 'name')
            ->where('id', '=', $usuarioId)
            ->get()[0];

        // Verificar si la fecha actual es anterior a la fecha de entrada menos los días de cancelación
        if (Carbon::now() < Carbon::parse($reservaCabana->fecha_entrada)->subDays($tipoCabanaDiasCancelacion)) {
            // Verificar si se realizó un pago para esta reserva
            if ($reservaCabana->id_pago != "") {
                // Realizar un reembolso utilizando la API de Stripe
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $refund = \Stripe\Refund::create([
                    'charge' => $reservaCabana->id_pago,
                ]);
            }

            // Eliminar la reserva de cabaña
            $reservaCabana->delete();

            // Enviar un correo electrónico al usuario notificando la cancelación
            Mail::to($usuario->email)->send(new ReservaCabanaBorrarMail([
                'fechaEntrada' => $fechaEntrada,
                'diasCancelacion' => $tipoCabanaDiasCancelacion,
                'nombre' => $usuario->name,
                'id_pago' => $reservaCabana->id_pago,
            ]));

            // Redirigir según el rol del usuario
            if (auth()->user()->admin) {
                return redirect('/cabanas/reserva')->with('success', 'La reserva ha sido borrada');
            } else {
                return Redirect::back()->with('cancelada', __('mail.lamentamos') . '. ' . __('mail.devuelto'));
            }
        } else {
            // Si la fecha actual es posterior a la fecha de entrada menos los días de cancelación, eliminar la reserva de cabaña
            $reservaCabana->delete();

            // Enviar un correo electrónico al usuario notificando la cancelación
            Mail::to($usuario->email)->send(new ReservaCabanaBorrarMail([
                'fechaEntrada' => $fechaEntrada,
                'diasCancelacion' => $tipoCabanaDiasCancelacion,
                'nombre' => $usuario->name,
                'id_pago' => $reservaCabana->id_pago,
            ]));

            // Redirigir según el rol del usuario
            if (auth()->user()->admin) {
                return redirect('/cabanas/reserva')->with('success', 'La reserva ha sido borrada');
            } else {
                return Redirect::back()->with('cancelada', __('mail.lamentamos') . '. ' . __('mail.noDevuelto'));
            }
        }
    }


    public function create()
    {
        // Obtener todos los usuarios para mostrar en la vista
        $usuarios = User::select('id', 'email')->get();

        // Obtener todos los tipos de cabañas para mostrar en la vista
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();

        // Retornar la vista de creación de reserva de cabañas con los usuarios y tipos de cabañas obtenidos
        return view('admin.reservaCabanas.create', ['usuarios' => $usuarios, 'tipoCabanas' => $tipoCabanas]);
    }


    public function store(ReservaCabanaRequest $request)
    {
        // Arreglo para almacenar los datos de la reserva
        $data = [];

        // Obtener los IDs de las cabañas disponibles para el tipo seleccionado y las fechas especificadas
        $ids_cabanas_buscadas = Cabana::select('id')->where('id_tipo_cabana', $request->tipoCabana)->get();

        // Variable para almacenar el ID de la cabaña válida
        $id_valido = -1;

        // Índice para iterar sobre los IDs de las cabañas buscadas
        $i = 0;

        // Buscar una cabaña disponible para las fechas especificadas
        while ($i < count($ids_cabanas_buscadas) && $id_valido == -1) {
            $idc = $ids_cabanas_buscadas[$i]->id;

            // Verificar si existe alguna reserva para esta cabaña y fechas especificadas
            $existe = ReservaCabana::select('id')
                ->where('id_cabana', $idc)
                ->where('fecha_entrada', '<', $request->fechaSalida)
                ->where('fecha_salida', '>', $request->fechaEntrada)
                ->get();

            // Si no existe ninguna reserva, la cabaña es válida
            if ($existe->isEmpty()) {
                $id_valido = $idc;
            }

            $i = $i + 1;
        }

        // Si se encontró una cabaña válida
        if ($id_valido != -1) {
            // Obtener las ofertas disponibles para la cabaña y las fechas especificadas
            $ofertas = DB::table('ofertas as o')
                ->select('o.id', 'o.fecha_inicio', 'o.fecha_fin', 'o.descuento', 'tc.precio', 'tc.precio_media_pension')
                ->join('cabanas as c', 'c.id_tipo_cabana', '=', 'o.id_tipo_cabana')
                ->join('tipo_cabanas as tc', 'tc.id', '=', 'c.id_tipo_cabana')
                ->where('c.id', $id_valido)
                ->where('o.fecha_inicio', '<', $request->fechaSalida)
                ->where('o.fecha_fin', '>', $request->fechaEntrada)
                ->get();

            // Obtener los precios base de la cabaña seleccionada
            $precios = TipoCabana::select('precio', 'precio_media_pension')->where('id', $request->tipoCabana)->get()[0];

            // Crear objetos DateTime para las fechas de entrada y salida
            $fechaInicioReserva = new DateTime($request->fechaEntrada);
            $fechaFinReserva = new DateTime($request->fechaSalida);

            // Calcular el precio de la reserva
            // Si no hay ofertas disponibles
            if ($ofertas->isEmpty()) {
                $duracionReserva = $fechaInicioReserva->diff($fechaFinReserva)->days;
                $precioHabitacion = $precios->precio * $duracionReserva;
            } else {
                $diasConOfertas = 0;
                $precioHabitacion = 0;

                // Iterar sobre las ofertas y calcular el precio con descuento
                foreach ($ofertas as $oferta) {
                    $fechaInicioOferta = new DateTime($oferta->fecha_inicio);
                    $fechaFinOferta = new DateTime($oferta->fecha_fin);

                    $inicio = max($fechaInicioReserva, $fechaInicioOferta);
                    $fin = min($fechaFinReserva, $fechaFinOferta);

                    if ($inicio <= $fin) {
                        $duracion = $inicio->diff($fin)->days;
                        $diasConOfertas += $duracion;
                        $precioHabitacion += $duracion * $oferta->precio * (1 - $oferta->descuento / 100);
                    }
                }

                $diasTotales = $fechaInicioReserva->diff($fechaFinReserva)->days + 1;
                $diasSinOfertas = $diasTotales - ($diasConOfertas + 1);
                $precioHabitacion += $diasSinOfertas * $precios->precio;
            }

            // Calcular el precio total, descuento y precio final
            $precioTotal = $fechaInicioReserva->diff($fechaFinReserva)->days * $precios->precio;
            $descuento = $precioTotal - $precioHabitacion;
            $precioMediaPension = $request->nHuespedes * $precios->precio_media_pension * $fechaInicioReserva->diff($fechaFinReserva)->days;

            // Almacenar los datos de la reserva en el arreglo $data
            $data['id_usuario'] = $request->usuario;
            $data['id_cabana'] = $id_valido;
            $data['fecha_entrada'] = $request->fechaEntrada;
            $data['fecha_salida'] = $request->fechaSalida;
            $data['n_huespedes'] = $request->nHuespedes;
            $data['precio_habitacion'] = round($precios->precio, 2);
            $data['precio_total'] = round($precioTotal, 2);
            $data['descuento'] = round($descuento, 2);
            $data['media_pension'] = $request->has('mediaPension') && $request->mediaPension === 'on' ? round($precioMediaPension, 2) : 0;
            $data['precio_final'] = round($precioHabitacion + $data['media_pension'], 2);
            $data['id_pago'] = "";

            // Si el usuario es administrador
            if (auth()->user()->admin) {
                // Crear la reserva en la base de datos
                $reserva = ReservaCabana::create($data);

                // Obtener información adicional para enviar por correo electrónico
                $tipoCabana = TipoCabana::select('nombre', 'dias_cancelacion')->where('id', $request->tipoCabana)->get()[0];
                $usuario = User::select('name', 'email')->where('id', $data["id_usuario"])->get()[0];

                // Enviar correo electrónico de confirmación de reserva al usuario
                Mail::to($usuario->email)->send(new ReservaCabanaMail([
                    'nombre' => $usuario->name,
                    'tipoCabana' => $tipoCabana->nombre,
                    'nCabana' => $data["id_cabana"],
                    'fechaEntrada' => $data["fecha_entrada"],
                    'fechaSalida' => $data["fecha_salida"],
                    'diasCancelacion' => $tipoCabana->dias_cancelacion,
                    'reservaId' => $reserva->id,
                ]));

                // Eliminar el archivo de factura de la reserva
                unlink(storage_path('app/reservaCabanas/factura' . $reserva->id . '.pdf'));

                // Redireccionar a la página de creación de reserva con un mensaje de éxito
                return redirect('/cabanas/reserva/create')->with('success', 'La reserva ha sido creada, se le ha mandado al usuario un correo de verificacion');
            } else {
                // Si el usuario no es administrador
                $tipoCabana = TipoCabana::select('id', 'nombre')->where('id', $request->tipoCabana)->get()[0];
                $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
                $salons = Salon::select('id', 'nombre')->get();

                // Mostrar la vista de pago con los detalles de la reserva
                return view('hotel.pago', ['data' => $data, 'salones' => $salons, 'cabanas' => $tipoCabanas, 'tipoCabana' => $tipoCabana]);
            }
        } else {
            // Si no se encontró ninguna cabaña disponible
            if (auth()->user()->admin) {
                // Redireccionar a la página de creación de reserva con un mensaje de error
                return redirect('/cabanas/reserva/create')->with('error', 'No hay cabañas disponibles para las fechas seleccionadas.');
            } else {
                // Redireccionar a la página anterior con un mensaje de error
                return Redirect::back()->with('error', __('reservas.cabanasDisp'));
            }
        }
    }

    // Método pagado para procesar el pago de la reserva

    public function pagado(Request $request)
    {
        // Iniciar una transacción de base de datos
        DB::beginTransaction();
        try {
            // Decodificar los datos del formulario
            $data = json_decode($request->input('data'), true);

            // Establecer la clave de la API de Stripe
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            // Obtener el monto del pago y la dirección de correo electrónico del formulario
            $amount = intval($data['precio_final'] * 100);
            $email = $request->input('email');

            // Crear un nuevo cliente de Stripe
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

            // Asignar el ID del pago a los datos de la reserva
            $data['id_pago'] = $charge->id;

            if ($charge->status) {
                // Si el cargo es exitoso

                // Crear la reserva en la base de datos
                $reserva = ReservaCabana::create($data);

                // Confirmar la transacción de la base de datos
                DB::commit();

                // Obtener información adicional para el correo de confirmación
                $tipoCabana = TipoCabana::select('nombre', 'dias_cancelacion')->where('id', $request->input('tipoCabana'))->get()[0];
                $usuario = User::select('name', 'email')->where('id', $data["id_usuario"])->get()[0];

                // Enviar correo de confirmación al usuario
                Mail::to($usuario->email)->send(new ReservaCabanaMail([
                    'nombre' => $usuario->name,
                    'tipoCabana' => $tipoCabana->nombre,
                    'nCabana' => $data["id_cabana"],
                    'fechaEntrada' => $data["fecha_entrada"],
                    'fechaSalida' => $data["fecha_salida"],
                    'diasCancelacion' => $tipoCabana->dias_cancelacion,
                    'reservaId' => $reserva->id,
                ]));

                // Eliminar el archivo de factura de la reserva
                unlink(storage_path('app/reservaCabanas/factura' . $reserva->id . '.pdf'));

                // Obtener información adicional para la vista de reserva completada
                $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
                $salons = Salon::select('id', 'nombre')->get();

                // Mostrar la vista de reserva completada con los detalles de la reserva
                return view('hotel.reservaCompletada', ['reserva' => $reserva, 'salones' => $salons, 'cabanas' => $tipoCabanas, 'tipoCabana' => $tipoCabana->nombre]);
            }
        } catch (InvalidRequestException $e) {
            // Manejar errores de solicitud inválida de Stripe
            Log::error("Error token", [$e]);
            return redirect('/home');
        } catch (Exception $e) {
            // Manejar otras excepciones
            dd([$e]);
            DB::rollBack();
            Log::error("Error pago", [$e]);
            return redirect('/home')->with('fallo', __('inicio.error'));
        }
    }


    // Método para editar una reserva

    public function edit($id, $error = '')
    {
        // Obtener usuarios y tipos de cabañas disponibles
        $usuarios = User::select('id', 'email')->get();
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();

        // Buscar la reserva a editar por su ID
        $reservaCabana = ReservaCabana::find($id);

        // Renderizar la vista de edición con los datos de la reserva, usuarios, tipos de cabañas y cualquier error proporcionado
        return view('admin.reservaCabanas.edit', ['reservaCabana' => $reservaCabana, 'tipoCabanas' => $tipoCabanas, 'usuarios' => $usuarios, 'error' => $error]);
    }


    // Método para actualizar una reserva

    public function update(ReservaCabanaRequest $request, $id)
    {
        $data = [];

        // Buscar cabañas disponibles para la reserva
        $ids_cabanas_buscadas = Cabana::select('id')->where('id_tipo_cabana', $request->tipoCabana)->get();
        $id_valido = -1;
        $i = 0;
        while ($i < count($ids_cabanas_buscadas) && $id_valido == -1) {
            $idc = $ids_cabanas_buscadas[$i]->id;

            // Verificar si la reserva choca con otras ya existentes
            $existe = ReservaCabana::select('id')->where('id', '!=', $id)->where('id_cabana', $idc)->where('fecha_entrada', '<', $request->fechaSalida)->where('fecha_salida', '>', $request->fechaEntrada)->get();
            if ($existe->isEmpty()) {
                $id_valido = $idc;
            }
            $i = $i + 1;
        }

        if ($id_valido != -1) {
            // Obtener ofertas disponibles para la cabaña y fechas seleccionadas
            $ofertas = DB::table('ofertas as o')
                ->select('o.id', 'o.fecha_inicio', 'o.fecha_fin', 'o.descuento', 'tc.precio', 'tc.precio_media_pension')
                ->join('cabanas as c', 'c.id_tipo_cabana', '=', 'o.id_tipo_cabana')
                ->join('tipo_cabanas as tc', 'tc.id', '=', 'c.id_tipo_cabana')
                ->where('c.id', $id_valido)
                ->where('o.fecha_inicio', '<', $request->fechaSalida)
                ->where('o.fecha_fin', '>', $request->fechaEntrada)
                ->get();

            // Obtener precios de la cabaña seleccionada
            $precios = TipoCabana::select('precio', 'precio_media_pension')->where('id', $request->tipoCabana)->get()[0];
            $fechaInicioReserva = new DateTime($request->fechaEntrada);
            $fechaFinReserva = new DateTime($request->fechaSalida);

            // Calcular precio de la reserva
            if ($ofertas->isEmpty()) {
                $duracionReserva = $fechaInicioReserva->diff($fechaFinReserva)->days;
                $precioHabitacion = $precios->precio * $duracionReserva;
            } else {
                $diasConOfertas = 0;
                $precioHabitacion = 0;
                foreach ($ofertas as $oferta) {
                    $fechaInicioOferta = new DateTime($oferta->fecha_inicio);
                    $fechaFinOferta = new DateTime($oferta->fecha_fin);

                    $inicio = max($fechaInicioReserva, $fechaInicioOferta);
                    $fin = min($fechaFinReserva, $fechaFinOferta);

                    if ($inicio <= $fin) {
                        $duracion = $inicio->diff($fin)->days;
                        $diasConOfertas += $duracion;
                        $precioHabitacion += $duracion * $oferta->precio * (1 - $oferta->descuento / 100);
                    }
                }
                $diasTotales = $fechaInicioReserva->diff($fechaFinReserva)->days + 1;
                $diasSinOfertas = $diasTotales - ($diasConOfertas + 1);
                $precioHabitacion += $diasSinOfertas * $precios->precio;
            }

            $precioTotal = $fechaInicioReserva->diff($fechaFinReserva)->days * $precios->precio;
            $descuento = $precioTotal - $precioHabitacion;

            $precioMediaPension = $request->nHuespedes * $precios->precio_media_pension * $fechaInicioReserva->diff($fechaFinReserva)->days;

            // Actualizar datos de la reserva
            $data['id_usuario'] = $request->usuario;
            $data['id_cabana'] = $id_valido;
            $data['fecha_entrada'] = $request->fechaEntrada;
            $data['fecha_salida'] = $request->fechaSalida;
            $data['n_huespedes'] = $request->nHuespedes;
            $data['precio_habitacion'] = round($precios->precio, 2);
            $data['precio_total'] = round($precioTotal, 2);
            $data['descuento'] = round($descuento, 2);
            $data['media_pension'] = $request->has('mediaPension') && $request->mediaPension === 'on' ? round($precioMediaPension, 2) : 0;

            // Actualizar precio final de la reserva
            if ($request->has('mediaPension')) {
                $data['precio_final'] = round($precioHabitacion + $precioMediaPension, 2);
            } else {
                $data['precio_final'] = round($precioHabitacion, 2);
            }

            // Actualizar ID de pago si está presente
            $data['id_pago'] = $request->idPago ? $request->idPago : "";

            // Encontrar y actualizar la reserva
            $reservaCabana = ReservaCabana::find($id);
            $reservaCabana->update($data);

            // Enviar correo de actualización al usuario
            $tipoCabana = TipoCabana::select('nombre', 'dias_cancelacion')->where('id', $request->tipoCabana)->get()[0];
            $usuario = User::select('name', 'email')->where('id', $request->usuario)->get()[0];
            Mail::to($usuario->email)->send(new ReservaCabanaActualizarMail([
                'nombre' => $usuario->name,
                'tipoCabana' => $tipoCabana->nombre,
                'nCabana' => $id_valido,
                'fechaEntrada' => $request->fechaEntrada,
                'fechaSalida' => $request->fechaSalida,
                'diasCancelacion' => $tipoCabana->dias_cancelacion,
                'reservaId' => $reservaCabana->id,
            ]));

            // Eliminar factura existente
            unlink(storage_path('app/reservaCabanas/factura' . $reservaCabana->id . '.pdf'));

            // Redireccionar con mensaje de éxito
            return redirect('/cabanas/reserva')->with('success', 'La reserva ha sido actualizada');
        } else {
            // Si no hay cabañas disponibles, regresar a la página de edición con un mensaje de error
            return $this->edit($id, __('reservas.cabanasDisp'));
        }
    }


    // Método para generar y enviar la factura en formato PDF

    public function facturaPdf(Request $request)
    {
        // Obtener la reserva de la base de datos
        $reservaCabana = ReservaCabana::find($request->input('idReservaCabana'));

        // Generar la vista de la factura en HTML
        $html = view('admin.reservaCabanas.facturaPdf', ['reservaCabana' => $reservaCabana])->render();

        // Crear un archivo temporal para almacenar el HTML
        $tempHtmlFile = tempnam(sys_get_temp_dir(), 'report_');
        File::put($tempHtmlFile, $html);

        // Definir la ubicación del archivo PDF generado
        $pdfPath = storage_path('app/reservaCabanas/factura' . $reservaCabana->id . '.pdf');

        // Generar el PDF y guardarlo en la ubicación especificada
        SnappyPdf::loadHTML($html)->save($pdfPath);

        // Enviar el PDF como respuesta y eliminarlo después de ser enviado
        return response()->file($pdfPath)->deleteFileAfterSend(true);
    }


    public function disponibilidad(Request $request)
    {
        // Validar las fechas de inicio y fin
        $request->validate([
            'fechaEntrada' => 'required|date',
            'fechaSalida' => 'required|date|after:fechaEntrada',
        ]);

        // Obtener todos los tipos de cabaña
        $tiposCabana = TipoCabana::all();

        // Array para almacenar el número de cabañas libres por tipo de cabaña
        $cabanasLibresPorTipo = [];

        // Iterar sobre cada tipo de cabaña
        foreach ($tiposCabana as $tipoCabana) {
            // Contador para el número de cabañas libres
            $cabanasLibres = 0;

            // Obtener todas las cabañas de este tipo
            $cabanas = Cabana::where('id_tipo_cabana', $tipoCabana->id)->get();

            // Iterar sobre cada cabaña y verificar disponibilidad
            foreach ($cabanas as $cabana) {
                // Verificar si la cabaña está disponible para las fechas dadas
                $existe = ReservaCabana::where('id_cabana', $cabana->id)
                    ->where('fecha_entrada', '<', $request->fechaSalida)
                    ->where('fecha_salida', '>', $request->fechaEntrada)
                    ->count();
                if ($existe == 0) {
                    // La cabaña está disponible
                    $cabanasLibres++;
                }
            }

            // Almacenar el número de cabañas libres para este tipo de cabaña
            $cabanasLibresPorTipo[$tipoCabana->nombre] = $cabanasLibres;
        }


        // Devolver el número de cabañas libres por tipo de cabaña
        return view('admin.reservaCabanas.disponibilidad', ['cabanasLibresPorTipo' => $cabanasLibresPorTipo, 'fechaEntrada' => $request->fechaEntrada, 'fechaSalida' => $request->fechaSalida]);
    }
}
