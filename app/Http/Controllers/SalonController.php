<?php

namespace App\Http\Controllers;

use App\DataTables\SalonsDataTable;
use App\Http\Requests\SalonRequest;
use App\Models\Salon;
use App\Models\TipoCabana;
use Illuminate\Http\Request;

class SalonController extends Controller
{
    public function index(SalonsDataTable $dataTable)
    {
        // Verificar si el usuario está autenticado como administrador
        if (auth()->check() && auth()->user()->admin) {
            // Si es administrador, renderizar la vista de DataTables para administrar salones
            return $dataTable->render('admin.salons.index');
        } else {
            // Si no es administrador, obtener todos los tipos de cabañas y salones disponibles
            $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
            $salones = Salon::all();

            // Renderizar la vista para mostrar los salones disponibles
            return view('hotel.salones', ['salones' => $salones, 'cabanas' => $tipoCabanas]);
        }
    }

    public function destroy($id)
    {
        // Encontrar y eliminar el salón con el ID proporcionado
        $salon = Salon::find($id);
        $salon->delete();

        // Redireccionar de vuelta a la página de salones con un mensaje de éxito
        return redirect('/salons')->with('success', 'El salón ha sido borrado');
    }

    public function create()
    {
        // Renderizar la vista para crear un nuevo salón
        return view('admin.salons.create');
    }

    public function store(SalonRequest $request)
    {
        // Validar y almacenar los datos del nuevo salón en la base de datos
        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_hora' => $request->precio_hora,
        ];
        Salon::create($data);

        // Redireccionar de vuelta a la página de salones con un mensaje de éxito
        return redirect('/salons')->with('success', 'El salón ha sido creado');
    }

    public function edit($id)
    {
        // Encontrar el salón que se va a editar y renderizar la vista de edición
        $salon = Salon::find($id);
        return view('admin.salons.edit', ['salon' => $salon]);
    }

    public function update(SalonRequest $request, $id)
    {
        // Encontrar el salón que se va a actualizar y actualizar sus datos en la base de datos
        $salon = Salon::find($id);
        $data = [
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio_hora' => $request->precio_hora,
        ];
        $salon->update($data);

        // Redireccionar de vuelta a la página de salones con un mensaje de éxito
        return redirect('/salons')->with('success', 'El salón ha sido actualizado');
    }
}
