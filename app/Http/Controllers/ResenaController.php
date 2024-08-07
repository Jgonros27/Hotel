<?php

namespace App\Http\Controllers;

use App\DataTables\ResenasDataTable;
use App\Http\Requests\ResenaRequest;
use App\Models\Resena;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ResenaController extends Controller
{
    // Método para mostrar la lista de reseñas en la vista de administración
    public function index(ResenasDataTable $dataTable)
    {
        // Obtiene todos los usuarios con sus IDs y correos electrónicos
        $usuarios = User::select('id', 'email')->get();
        // Renderiza la vista de administración de reseñas pasando los usuarios
        return $dataTable->render('admin.resenas.index', ['usuarios' => $usuarios]);
    }

    // Método para borrar una reseña por su ID
    public function destroy($id)
    {
        // Encuentra la reseña por su ID
        $resena = Resena::find($id);
        // Elimina la reseña
        $resena->delete();
        // Redirige a la lista de reseñas con un mensaje de éxito
        return redirect('/resenas')->with('success', 'La reseña ha sido borrada');
    }

    // Método para mostrar el formulario de creación de una nueva reseña
    public function create()
    {
        // Obtiene todos los usuarios con sus IDs y nombres
        $usuarios = User::select('id', 'name')->get();
        // Renderiza la vista de creación de reseñas pasando los usuarios
        return view('admin.resenas.create', compact('usuarios'));
    }

    // Método para guardar una nueva reseña
    public function store(ResenaRequest $request)
    {
        // Crea un array de datos a partir de la solicitud
        $data = [];
        $data['id_usuario'] = $request->usuario;
        $data['puntuacion'] = $request->puntuacion;
        // Asigna el comentario si está presente, de lo contrario, asigna una cadena vacía
        $data['comentario'] = $request->comentario ? $request->comentario : "";

        // Crea una nueva reseña con los datos proporcionados
        Resena::create($data);

        // Redirige según el rol del usuario (admin o no admin)
        if (auth()->user()->admin) {
            return redirect('/resenas')->with('success', 'La reseña ha sido creada');
        } else {
            return Redirect::back()->with('resena', true);
        }
    }

    // Método para mostrar el formulario de edición de una reseña existente
    public function edit($id)
    {
        // Obtiene todos los usuarios con sus IDs y nombres
        $usuarios = User::select('id', 'name')->get();
        // Encuentra la reseña por su ID
        $resena = Resena::find($id);
        // Renderiza la vista de edición de reseñas pasando la reseña y los usuarios
        return view('admin.resenas.edit', ['resena' => $resena, 'usuarios' => $usuarios]);
    }

    // Método para actualizar una reseña existente
    public function update(ResenaRequest $request, $id)
    {
        // Encuentra la reseña por su ID
        $resena = Resena::find($id);
        // Crea un array de datos a partir de la solicitud
        $data = [];
        $data['id_usuario'] = $request->usuario;
        $data['puntuacion'] = $request->puntuacion;
        // Asigna el comentario si está presente, de lo contrario, asigna una cadena vacía
        $data['comentario'] = $request->comentario ? $request->comentario : "";

        // Actualiza la reseña con los datos proporcionados
        $resena->update($data);

        // Redirige a la lista de reseñas con un mensaje de éxito
        return redirect('/resenas')->with('success', 'La reseña ha sido actualizada');
    }
}
