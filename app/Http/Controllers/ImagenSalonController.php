<?php

namespace App\Http\Controllers;

use App\DataTables\ImagenSalonsDataTable;
use App\Http\Requests\ImagenSalonRequest;
use App\Http\Requests\imagenSalonUpdateRequest;
use App\Models\ImagenSalon;
use App\Models\Salon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImagenSalonController extends Controller
{
    public function index(ImagenSalonsDataTable $dataTable, Request $request){
        $salons = Salon::select('id', 'nombre')->get();
        $salonId = $request->input('salonId');
        return $dataTable->render('admin.imagenSalons.index',['salons'=>$salons,'salonId'=>$salonId]);
    }

    public function destroy($id){
        $imagenSalon = ImagenSalon::find($id);
        $url = 'imagenes_salons/'.$imagenSalon->url;
        Storage::disk('public')->delete($url);
        $imagenSalon->delete();
        return redirect('/salons/imagenes')->with('success','La imagen ha sido borrada');
    }

    public function create(){
        $salons = Salon::select('id', 'nombre')->get();
        return view('admin.imagenSalons.create', compact('salons'));
    }

    public function store(ImagenSalonRequest $request){
        $data['id_salon'] = $request->salon;

        $nombreEncriptado = basename(Storage::disk('public')->put("imagenes_salons",$request->imagenSalon));
        $data['url'] =$nombreEncriptado;

        $nombreOriginal = $request->imagenSalon->getClientOriginalName();
        if ($request->nombreImagen) {
            $data['nombre_imagen'] = $request->nombreImagen;
        }else{
            $data['nombre_imagen'] = $nombreOriginal;
        }
        

        ImagenSalon::create($data);

        return redirect('/salons/imagenes')->with('success', 'La imagen ha sido creada');
    }

    public function edit($id){
        $imagenSalon = ImagenSalon::find($id);
        $salons = Salon::select('id', 'nombre')->get();
        return view('admin.imagenSalons.edit',['imagenSalon'=>$imagenSalon,'salons'=>$salons]);
    }

    public function update(imagenSalonUpdateRequest $request, $id){
        $imagenSalon = ImagenSalon::find($id);
        $data = [];
        $data['id_salon'] = $request->salon;
        

        if ($request->imagenSalon) {
            Storage::disk('public')->delete("imagenes_salons/".$imagenSalon->url);
            $nombreEncriptado = basename(Storage::disk('public')->put("imagenes_salons",$request->imagenSalon));
            $data['url'] = $nombreEncriptado;
        }else{
            $data['url'] = $imagenSalon->url;
        }

        if ($request->nombreImagen) {
            $data['nombre_imagen'] = $request->nombreImagen;
        }else{
            $data['nombre_imagen'] = $imagenSalon->nombre_imagen;
        }

        
        $imagenSalon->update($data);

        return redirect('/salons/imagenes')->with('success', 'La imagen ha sido actualizada');
    }
}
