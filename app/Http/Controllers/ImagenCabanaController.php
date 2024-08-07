<?php

namespace App\Http\Controllers;

use App\DataTables\ImagenCabanasDataTable;
use App\Http\Requests\ImagenCabanaRequest;
use App\Http\Requests\imagenCabanaUpdateRequest;
use App\Models\ImagenCabana;
use App\Models\TipoCabana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenCabanaController extends Controller
{
    // Método para mostrar la lista de imágenes de cabañas en la vista de administración
    public function index(ImagenCabanasDataTable $dataTable, Request $request)
    {
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Obtiene el ID del tipo de cabaña desde la solicitud
        $tipoCabanaId = $request->input('tipoCabanaId');

        // Renderiza la vista de administración de imágenes de cabañas pasando los tipos de cabañas y el ID del tipo de cabaña
        return $dataTable->render('admin.imagenCabanas.index', ['tipoCabanas' => $tipoCabanas, 'tipoCabanaId' => $tipoCabanaId]);
    }

    // Método para borrar una imagen de cabaña por su ID
    public function destroy($id)
    {
        // Encuentra la imagen de la cabaña por su ID
        $imagenCabana = ImagenCabana::find($id);
        // Construye la URL de la imagen
        $url = 'imagenes_cabanas/' . $imagenCabana->url;
        // Elimina la imagen del almacenamiento
        Storage::disk('public')->delete($url);
        // Elimina el registro de la imagen de la base de datos
        $imagenCabana->delete();
        // Redirige a la lista de imágenes de cabañas con un mensaje de éxito
        return redirect('/cabanas/imagenes')->with('success', 'La imagen ha sido borrada');
    }

    // Método para mostrar el formulario de creación de una nueva imagen de cabaña
    public function create()
    {
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de creación de imágenes de cabañas pasando los tipos de cabañas
        return view('admin.imagenCabanas.create', compact('tipoCabanas'));
    }

    // Método para guardar una nueva imagen de cabaña
    public function store(ImagenCabanaRequest $request)
    {
        // Crea un array de datos a partir de la solicitud
        $data['id_tipo_cabana'] = $request->tipoCabana;

        // Guarda la imagen en el almacenamiento y obtiene su nombre encriptado
        $nombreEncriptado = basename(Storage::disk('public')->put("imagenes_cabanas", $request->imagenCabana));
        $data['url'] = $nombreEncriptado;

        // Obtiene el nombre original de la imagen
        $nombreOriginal = $request->imagenCabana->getClientOriginalName();
        // Si se proporciona un nombre de imagen en la solicitud, lo usa; de lo contrario, usa el nombre original
        if ($request->nombreImagen) {
            $data['nombre_imagen'] = $request->nombreImagen;
        } else {
            $data['nombre_imagen'] = $nombreOriginal;
        }

        // Crea una nueva imagen de cabaña con los datos proporcionados
        ImagenCabana::create($data);

        // Redirige a la lista de imágenes de cabañas con un mensaje de éxito
        return redirect('/cabanas/imagenes')->with('success', 'La imagen ha sido creada');
    }

    // Método para mostrar el formulario de edición de una imagen de cabaña existente
    public function edit($id)
    {
        // Encuentra la imagen de la cabaña por su ID
        $imagenCabana = ImagenCabana::find($id);
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de edición de imágenes de cabañas pasando la imagen y los tipos de cabañas
        return view('admin.imagenCabanas.edit', ['imagenCabana' => $imagenCabana, 'tipoCabanas' => $tipoCabanas]);
    }

    // Método para actualizar una imagen de cabaña existente
    public function update(imagenCabanaUpdateRequest $request, $id)
    {
        // Encuentra la imagen de la cabaña por su ID
        $imagenCabana = ImagenCabana::find($id);
        // Crea un array de datos a partir de la solicitud
        $data['id_tipo_cabana'] = $request->tipoCabana;

        // Si se proporciona una nueva imagen en la solicitud, la guarda y actualiza la URL
        if ($request->imagenCabana) {
            Storage::disk('public')->delete("imagenes_cabanas/" . $imagenCabana->url);
            $nombreEncriptado = basename(Storage::disk('public')->put("imagenes_cabanas", $request->imagenCabana));
            $data['url'] = $nombreEncriptado;
        } else {
            // Si no se proporciona una nueva imagen, mantiene la URL actual
            $data['url'] = $imagenCabana->url;
        }

        // Si se proporciona un nuevo nombre de imagen en la solicitud, lo usa; de lo contrario, mantiene el nombre actual
        if ($request->nombreImagen) {
            $data['nombre_imagen'] = $request->nombreImagen;
        } else {
            $data['nombre_imagen'] = $imagenCabana->nombre_imagen;
        }

        // Actualiza la imagen de la cabaña con los datos proporcionados
        $imagenCabana->update($data);

        // Redirige a la lista de imágenes de cabañas con un mensaje de éxito
        return redirect('/cabanas/imagenes')->with('success', 'La imagen ha sido actualizada');
    }
}
