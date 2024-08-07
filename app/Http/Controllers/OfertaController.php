<?php

namespace App\Http\Controllers;

use App\DataTables\OfertasDataTable;
use App\Http\Requests\OfertaRequest;
use App\Models\Oferta;
use App\Models\TipoCabana;
use Illuminate\Http\Request;

class OfertaController extends Controller
{
    // Método para mostrar la lista de ofertas en la vista de administración
    public function index(OfertasDataTable $dataTable)
    {
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de administración de ofertas pasando los tipos de cabañas
        return $dataTable->render('admin.ofertas.index', ['tipoCabanas' => $tipoCabanas]);
    }

    // Método para borrar una oferta por su ID
    public function destroy($id)
    {
        // Encuentra la oferta por su ID
        $oferta = Oferta::find($id);
        // Elimina la oferta
        $oferta->delete();
        // Redirige a la lista de ofertas con un mensaje de éxito
        return redirect('/ofertas')->with('success', 'La oferta ha sido borrada');
    }

    // Método para mostrar el formulario de creación de una nueva oferta
    public function create()
    {
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de creación de ofertas pasando los tipos de cabañas
        return view('admin.ofertas.create', compact('tipoCabanas'));
    }

    // Método para guardar una nueva oferta
    public function store(OfertaRequest $request)
    {
        // Crea un array de datos a partir de la solicitud
        $data = [];
        $data['id_tipo_cabana'] = $request->tipoCabana;
        $data['descuento'] = $request->descuento;
        $data['fecha_inicio'] = $request->fechaInicio;
        $data['fecha_fin'] = $request->fechaFin;

        // Crea una nueva oferta con los datos proporcionados
        Oferta::create($data);

        // Redirige a la lista de ofertas con un mensaje de éxito
        return redirect('/ofertas')->with('success', 'La oferta ha sido creada');
    }

    // Método para mostrar el formulario de edición de una oferta existente
    public function edit($id)
    {
        // Encuentra la oferta por su ID
        $oferta = Oferta::find($id);
        // Obtiene todos los tipos de cabañas con sus IDs y nombres
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        // Renderiza la vista de edición de ofertas pasando la oferta y los tipos de cabañas
        return view('admin.ofertas.edit', ['oferta' => $oferta, 'tipoCabanas' => $tipoCabanas]);
    }

    // Método para actualizar una oferta existente
    public function update(OfertaRequest $request, $id)
    {
        // Encuentra la oferta por su ID
        $oferta = Oferta::find($id);
        // Crea un array de datos a partir de la solicitud
        $data = [];
        $data['id_tipo_cabana'] = $request->tipoCabana;
        $data['descuento'] = $request->descuento;
        $data['fecha_inicio'] = $request->fechaInicio;
        $data['fecha_fin'] = $request->fechaFin;

        // Actualiza la oferta con los datos proporcionados
        $oferta->update($data);

        // Redirige a la lista de ofertas con un mensaje de éxito
        return redirect('/ofertas')->with('success', 'La oferta ha sido actualizada');
    }
}
