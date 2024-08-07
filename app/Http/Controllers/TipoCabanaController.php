<?php

namespace App\Http\Controllers;

use App\DataTables\TipoCabanasDataTable;
use App\Http\Requests\TipoCabanaRequest;
use App\Models\Salon;
use App\Models\TipoCabana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TipoCabanaController extends Controller
{
    public function index(TipoCabanasDataTable $dataTable)
    {
        // Verificar si el usuario está autenticado como administrador
        if (auth()->check() && auth()->user()->admin) {
            // Si es administrador, renderizar la vista de DataTables para administrar tipos de cabañas
            return $dataTable->render('admin.tipoCabanas.index');
        } else {
            // Si no es administrador, obtener todos los salones y tipos de cabañas disponibles
            $salons = Salon::select('id', 'nombre')->get();
            $tipoCabanas = TipoCabana::select(
                'tipo_cabanas.nombre',
                'tipo_cabanas.precio',
                'tipo_cabanas.id',
                'tipo_cabanas.capacidad',
                'tipo_cabanas.precio_media_pension',
                'tipo_cabanas.dias_cancelacion',
                DB::raw('MIN(imagen_cabanas.url) AS primera_url')
            )
                ->join('imagen_cabanas', 'tipo_cabanas.id', '=', 'imagen_cabanas.id_tipo_cabana')
                ->groupBy('tipo_cabanas.nombre', 'tipo_cabanas.precio', 'tipo_cabanas.id', 'tipo_cabanas.capacidad', 'tipo_cabanas.precio_media_pension', 'tipo_cabanas.dias_cancelacion')
                ->get();

            // Renderizar la vista para mostrar los tipos de cabañas disponibles
            return view('hotel.cabanas', ['salones' => $salons, 'cabanas' => $tipoCabanas]);
        }
    }

    public function show($id)
    {
        // Obtener todos los tipos de cabañas y salones disponibles para mostrar la información detallada de un tipo de cabaña
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        $salons = Salon::select('id', 'nombre')->get();
        $cabana = TipoCabana::find($id);

        // Renderizar la vista para mostrar la información detallada del tipo de cabaña seleccionado
        return view('hotel.cabana', ['cabana' => $cabana, 'salones' => $salons, 'cabanas' => $tipoCabanas]);
    }

    public function destroy($id)
    {
        // Encontrar y eliminar el tipo de cabaña con el ID proporcionado
        $tipoCabana = TipoCabana::find($id);
        $tipoCabana->delete();

        // Redireccionar de vuelta a la página de tipos de cabañas con un mensaje de éxito
        return redirect('/cabanas/tipo')->with('success', 'El tipo de cabaña ha sido borrado');
    }

    public function create()
    {
        // Renderizar la vista para crear un nuevo tipo de cabaña
        return view('admin.tipoCabanas.create');
    }

    public function store(TipoCabanaRequest $request)
    {
        // Validar y almacenar los datos del nuevo tipo de cabaña en la base de datos
        $data = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'capacidad' => $request->capacidad,
            'servicios' => $request->servicios,
            'precio_media_pension' => $request->precio_media_pension,
            'dias_cancelacion' => $request->dias_cancelacion,
            'especificaciones' => $request->especificaciones,
        ];
        TipoCabana::create($data);

        // Redireccionar de vuelta a la página de tipos de cabañas con un mensaje de éxito
        return redirect('/cabanas/tipo')->with('success', 'El tipo de cabaña ha sido creado');
    }

    public function edit($id)
    {
        // Encontrar el tipo de cabaña que se va a editar y renderizar la vista de edición
        $tipoCabana = TipoCabana::find($id);
        return view('admin.tipoCabanas.edit', ['tipoCabana' => $tipoCabana]);
    }

    public function update(TipoCabanaRequest $request, $id)
    {
        // Encontrar el tipo de cabaña que se va a actualizar y actualizar sus datos en la base de datos
        $tipoCabana = TipoCabana::find($id);
        $data = [
            'nombre' => $request->nombre,
            'precio' => $request->precio,
            'capacidad' => $request->capacidad,
            'servicios' => $request->servicios,
            'precio_media_pension' => $request->precio_media_pension,
            'dias_cancelacion' => $request->dias_cancelacion,
            'especificaciones' => $request->especificaciones,
        ];
        $tipoCabana->update($data);

        // Redireccionar de vuelta a la página de tipos de cabañas con un mensaje de éxito
        return redirect('/cabanas/tipo')->with('success', 'El tipo de cabaña ha sido actualizado');
    }
}
