<?php

namespace App\Http\Controllers;

use App\DataTables\CabanasDataTable;
use App\Http\Requests\CabanaRequest;
use App\Models\Cabana;
use App\Models\Salon;
use App\Models\TipoCabana;
use Illuminate\Http\Request;

class CabanaController extends Controller
{
    // Método para mostrar la lista de cabañas en la vista de administración
    public function index(CabanasDataTable $dataTable){
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de administración de cabañas pasando los tipos de cabañas
        return $dataTable->render('admin.cabanas.index', ['tipoCabanas' => $tipoCabanas]);
    }

    // Método para mostrar la lista de cabañas y salones en la vista de usuarios
    public function indexUsuarios(CabanasDataTable $dataTable){
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Obtiene todos los salones con sus IDs y nombres
        $salons = Salon::select('id', 'nombre')->get();
        // Renderiza la vista de inicio del hotel pasando los tipos de cabañas y salones
        return view('hotel.inicio', ['salons' => $salons, 'cabanas' => $tipoCabanas]);
    }

    // Método para borrar una cabaña por su ID
    public function destroy($id){
        // Encuentra la cabaña por su ID
        $cabana = Cabana::find($id);
        // Elimina la cabaña
        $cabana->delete();
        // Redirige a la lista de cabañas con un mensaje de éxito
        return redirect('/cabanas')->with('success', 'La cabaña ha sido borrada');
    }

    // Método para mostrar el formulario de creación de una nueva cabaña
    public function create(){
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de creación de cabañas pasando los tipos de cabañas
        return view('admin.cabanas.create', compact('tipoCabanas'));
    }

    // Método para guardar una nueva cabaña
    public function store(CabanaRequest $request){
        // Crea un array de datos a partir de la solicitud
        $data = [];
        $data['id_tipo_cabana'] = $request->tipoCabana;
        
        // Crea una nueva cabaña con los datos proporcionados
        Cabana::create($data);
        
        // Redirige a la lista de cabañas con un mensaje de éxito
        return redirect('/cabanas')->with('success', 'La cabaña ha sido creada');
    }

    // Método para mostrar el formulario de edición de una cabaña existente
    public function edit($id){
        // Encuentra la cabaña por su ID
        $cabana = Cabana::find($id);
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de edición de cabañas pasando la cabaña y los tipos de cabañas
        return view('admin.cabanas.edit', ['cabana' => $cabana, 'tipoCabanas' => $tipoCabanas]);
    }

    // Método para actualizar una cabaña existente
    public function update(CabanaRequest $request, $id){
        // Crea un array de datos a partir de la solicitud
        $data = [];
        // Encuentra la cabaña por su ID
        $cabana = Cabana::find($id);
        $data['id_tipo_cabana'] = $request->tipoCabana;
        
        // Actualiza la cabaña con los datos proporcionados
        $cabana->update($data);
        
        // Redirige a la lista de cabañas con un mensaje de éxito
        return redirect('/cabanas')->with('success', 'La cabaña ha sido actualizada');
    }
}
