<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Http\Requests\UsuarioRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        // Renderizar la vista para administrar usuarios utilizando DataTables
        return $dataTable->render('admin.usuarios.index');
    }

    public function destroy($id)
    {
        // Buscar y eliminar el usuario con el ID proporcionado
        $usuario = User::find($id);
        $usuario->delete();

        // Redireccionar de vuelta a la página de usuarios con un mensaje de éxito
        return redirect('/usuarios')->with('success', 'El usuario ha sido borrado');
    }

    public function create()
    {
        // Renderizar la vista para crear un nuevo usuario
        return view('admin.usuarios.create');
    }

    public function store(UsuarioRequest $request)
    {
        // Validar y almacenar los datos del nuevo usuario en la base de datos
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'admin' => $request->has('admin') && $request->admin === 'on' ? 1 : 0,
        ];
        User::create($data);

        // Redireccionar de vuelta a la página de usuarios con un mensaje de éxito
        return redirect('/usuarios')->with('success', 'El usuario ha sido creado');
    }

    public function edit($id)
    {
        // Encontrar el usuario que se va a editar y renderizar la vista de edición
        $usuario = User::find($id);
        return view('admin.usuarios.edit', ['usuario' => $usuario]);
    }

    public function update(UsuarioUpdateRequest $request, User $usuario)
    {
        // Validar y actualizar los datos del usuario en la base de datos
        $data = [
            'name' => $request->name ?: $usuario->name,
            'email' => $request->email ?: $usuario->email,
            'password' => $request->password ?: $usuario->password,
            'admin' => $request->has('admin') && $request->admin === 'on' ? 1 : 0,
        ];

        $usuario->update($data);

        // Redireccionar de vuelta a la página de usuarios con un mensaje de éxito
        return redirect('/usuarios')->with('success', 'El usuario ha sido actualizado');
    }
}
