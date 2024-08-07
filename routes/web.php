<?php

use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\CabanaController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursosTipoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenCabanaController;
use App\Http\Controllers\ImagenSalonController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OfertaController;
use App\Http\Controllers\PagoController;
use App\Http\Controllers\ResenaController;
use App\Http\Controllers\ReservaCabanaController;
use App\Http\Controllers\ReservaSalonController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\SalonController;
use App\Http\Controllers\TipoCabanaController;
use App\Http\Controllers\UsersController;
use App\Http\Requests\CursosTipoRequest;
use App\Models\Oferta;
use App\Models\Resena;
use App\Models\ReservaCabana;
use App\Models\ReservaSalon;
use App\Models\Salon;
use App\Models\TipoCabana;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

// Definición de rutas web

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Ruta para redireccionar al inicio de acuerdo al tipo de usuario
Route::get('/home', function () {
    if (Auth::check()) {
        if (Auth::user()->admin) {
            return redirect('/usuarios'); // Si es administrador, redirige a la gestión de usuarios
        } else {
            return redirect('/'); // Si no es administrador, redirige al inicio
        }
    } else {
        return redirect('/'); // Si no ha iniciado sesión, redirige al inicio
    }
})->name('home');

// Ruta para la página de inicio
Route::get('/', function () {
    // Obtiene los tipos de cabañas y salones disponibles
    $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
    $salons = Salon::select('id', 'nombre')->get();

    // Obtiene las ofertas disponibles con su respectiva imagen
    $ofertas = Oferta::select(
        'ofertas.descuento',
        'ofertas.fecha_inicio',
        'ofertas.fecha_fin',
        'tipo_cabanas.nombre',
        DB::raw('MIN(imagen_cabanas.url) AS primera_url')
    )
        ->join('tipo_cabanas', 'ofertas.id_tipo_cabana', '=', 'tipo_cabanas.id')
        ->join('imagen_cabanas', 'tipo_cabanas.id', '=', 'imagen_cabanas.id_tipo_cabana')
        ->where('ofertas.fecha_inicio', '>=', now()) // Filtrar por fecha de inicio mayor al día de hoy
        ->groupBy('ofertas.descuento', 'ofertas.fecha_inicio', 'ofertas.fecha_fin', 'tipo_cabanas.nombre')
        ->get();

    // Obtiene las últimas 10 reseñas ordenadas por puntuación
    $resenas = Resena::select('users.name', 'comentario', 'puntuacion')
        ->join('users', 'resenas.id_usuario', '=', 'users.id')
        ->orderByDesc('puntuacion')
        ->take(10)
        ->get();

    // Retorna la vista de la página de inicio con los datos obtenidos
    return view('hotel.inicio', ['opiniones' => $resenas, 'ofertas' => $ofertas, 'salones' => $salons, 'cabanas' => $tipoCabanas]);
})->name('inicio');

// Ruta para la página de ayuda
Route::get('/ayuda', function () {

    if (Auth::check() && Auth::user()->admin) {
        // Retorna la vista de la página de ayuda con los datos obtenidos
        return view('admin.ayuda');
    } else {
        // Obtiene los tipos de cabañas y salones disponibles
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        $salons = Salon::select('id', 'nombre')->get();

        // Retorna la vista de la página de ayuda con los datos obtenidos
        return view('hotel.ayuda', ['salones' => $salons, 'cabanas' => $tipoCabanas]);
    }
})->name('ayuda');

// Ruta para la página "Sobre Nosotros"
Route::get('/sobreNosotros', function () {
    // Obtiene los tipos de cabañas y salones disponibles
    $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
    $salons = Salon::select('id', 'nombre')->get();

    // Retorna la vista de la página "Sobre Nosotros" con los datos obtenidos
    return view('hotel.sobreNosotros', ['salones' => $salons, 'cabanas' => $tipoCabanas]);
})->name('sobreNosotros');

// Rutas para la gestión de tipos de cabañas
Route::get('/cabanas/tipo', [TipoCabanaController::class, 'index'])->name('tipoCabanas.index');
Route::get('/cabanas/tipo/ver/{cabana}', [TipoCabanaController::class, 'show'])->name('tipoCabanas.show');

// Ruta para mostrar los salones
Route::get('/salons', [SalonController::class, 'index'])->name('salons.index');

// Ruta para mostrar el mensaje de acceso denegado
Route::get('/acceso-denegado', function () {
    return view('acceso-denegado');
})->name('acceso-denegado');

// Grupo de rutas protegidas por autenticación
Route::middleware('auth')->group(function () {

    // Ruta para mostrar las reservas del usuario
    Route::get('/reservas', function () {
        $tipoCabanas = TipoCabana::select('id', 'nombre')->get();
        $salons = Salon::select('id', 'nombre')->get();
        $usuarioId = auth()->user()->id;

        $reservaCabanas = ReservaCabana::where('id_usuario', $usuarioId)->get();

        $reservaSalones = ReservaSalon::where('id_usuario', $usuarioId)->get();

        return view('hotel.reservas', ['salones' => $salons, 'cabanas' => $tipoCabanas, 'reservaSalones' => $reservaSalones, 'reservaCabanas' => $reservaCabanas]);
    })->name('reservas.index');


    // Rutas de gestión de usuarios
    Route::get('/usuarios', [UsersController::class, 'index'])->name('usuarios.index')->middleware('admin');
    Route::get('/usuarios/create', [UsersController::class, 'create'])->name('usuarios.create')->middleware('admin');
    Route::post('/usuarios', [UsersController::class, 'store'])->name('usuarios.store')->middleware('admin');
    Route::get('/usuarios/edit/{usuario}', [UsersController::class, 'edit'])->name('usuarios.edit')->middleware('admin');
    Route::patch('/usuarios/{usuario}', [UsersController::class, 'update'])->name('usuarios.update')->middleware('admin');
    Route::delete('/usuarios/{usuario}', [UsersController::class, 'destroy'])->name('usuarios.destroy')->middleware('admin');

    // Rutas de gestión de cabañas
    Route::get('/cabanas', [CabanaController::class, 'index'])->name('cabanas.index')->middleware('admin');
    Route::get('/cabanas/create', [CabanaController::class, 'create'])->name('cabanas.create')->middleware('admin');
    Route::post('/cabanas', [CabanaController::class, 'store'])->name('cabanas.store')->middleware('admin');
    Route::get('/cabanas/edit/{cabana}', [CabanaController::class, 'edit'])->name('cabanas.edit')->middleware('admin');
    Route::patch('/cabanas/{cabana}', [CabanaController::class, 'update'])->name('cabanas.update')->middleware('admin');
    Route::delete('/cabanas/{cabana}', [CabanaController::class, 'destroy'])->name('cabanas.destroy')->middleware('admin');

    // Rutas de gestión de tipos de cabañas
    Route::get('/cabanas/tipo/create', [TipoCabanaController::class, 'create'])->name('tipoCabanas.create')->middleware('admin');
    Route::post('/cabanas/tipo', [TipoCabanaController::class, 'store'])->name('tipoCabanas.store')->middleware('admin');
    Route::get('/cabanas/tipo/edit/{cabana}', [TipoCabanaController::class, 'edit'])->name('tipoCabanas.edit')->middleware('admin');
    Route::patch('/cabanas/tipo/{cabana}', [TipoCabanaController::class, 'update'])->name('tipoCabanas.update')->middleware('admin');
    Route::delete('/cabanas/tipo/{cabana}', [TipoCabanaController::class, 'destroy'])->name('tipoCabanas.destroy')->middleware('admin');

    // Rutas de gestión de reservas de cabañas
    Route::get('/cabanas/reserva', [ReservaCabanaController::class, 'index'])->name('reservaCabanas.index')->middleware('admin');
    Route::get('/cabanas/reserva/create', [ReservaCabanaController::class, 'create'])->name('reservaCabanas.create')->middleware('admin');
    Route::post('/cabanas/reserva', [ReservaCabanaController::class, 'store'])->name('reservaCabanas.store');
    Route::post('/cabanas/pago', [ReservaCabanaController::class, 'pagado'])->name('reservaCabanas.pagado');
    Route::get('/cabanas/reserva/edit/{cabana}', [ReservaCabanaController::class, 'edit'])->name('reservaCabanas.edit')->middleware('admin');
    Route::patch('/cabanas/reserva/{cabana}', [ReservaCabanaController::class, 'update'])->name('reservaCabanas.update')->middleware('admin');
    Route::delete('/cabanas/reserva/{cabana}', [ReservaCabanaController::class, 'destroy'])->name('reservaCabanas.destroy');
    Route::get('/cabanas/reserva/facturaPdf', [ReservaCabanaController::class, 'facturaPdf'])->name('reservaCabanas.factura');
    Route::get('/cabanas/disponibilidad', function () {
        return view('admin.reservaCabanas.disponibilidad');
    })->name('reservaCabanas.disponibilidad')->middleware('admin');
    Route::post('/cabanas/disponibilidad', [ReservaCabanaController::class, 'disponibilidad'])->name('reservaCabanas.disponibilidad')->middleware('admin');

    // Rutas de gestión de imágenes de cabañas
    Route::get('/cabanas/imagenes', [ImagenCabanaController::class, 'index'])->name('imagenCabanas.index')->middleware('admin');
    Route::get('/cabanas/imagenes/create', [ImagenCabanaController::class, 'create'])->name('imagenCabanas.create')->middleware('admin');
    Route::post('/cabanas/imagenes', [ImagenCabanaController::class, 'store'])->name('imagenCabanas.store')->middleware('admin');
    Route::get('/cabanas/imagenes/edit/{cabana}', [ImagenCabanaController::class, 'edit'])->name('imagenCabanas.edit')->middleware('admin');
    Route::post('/cabanas/imagenes/{cabana}', [ImagenCabanaController::class, 'update'])->name('imagenCabanas.update')->middleware('admin');
    Route::delete('/cabanas/imagenes/{cabana}', [ImagenCabanaController::class, 'destroy'])->name('imagenCabanas.destroy')->middleware('admin');

    // Rutas de gestión de ofertas
    Route::get('/ofertas', [OfertaController::class, 'index'])->name('ofertas.index')->middleware('admin');
    Route::get('/ofertas/create', [OfertaController::class, 'create'])->name('ofertas.create')->middleware('admin');
    Route::post('/ofertas', [OfertaController::class, 'store'])->name('ofertas.store')->middleware('admin');
    Route::get('/ofertas/edit/{oferta}', [OfertaController::class, 'edit'])->name('ofertas.edit')->middleware('admin');
    Route::patch('/ofertas/{oferta}', [OfertaController::class, 'update'])->name('ofertas.update')->middleware('admin');
    Route::delete('/ofertas/{oferta}', [OfertaController::class, 'destroy'])->name('ofertas.destroy')->middleware('admin');


    // Rutas de gestión de salones
    Route::get('/salons/create', [SalonController::class, 'create'])->name('salons.create')->middleware('admin');
    Route::post('/salons', [SalonController::class, 'store'])->name('salons.store')->middleware('admin');
    Route::get('/salons/edit/{salon}', [SalonController::class, 'edit'])->name('salons.edit')->middleware('admin');
    Route::patch('/salons/{salon}', [SalonController::class, 'update'])->name('salons.update')->middleware('admin');
    Route::delete('/salons/{salon}', [SalonController::class, 'destroy'])->name('salons.destroy')->middleware('admin');

    // Rutas de gestión de reservas de salones
    Route::get('/salons/reserva', [ReservaSalonController::class, 'index'])->name('reservaSalons.index')->middleware('admin');
    Route::get('/salons/reserva/create', [ReservaSalonController::class, 'create'])->name('reservaSalons.create')->middleware('admin');
    Route::post('/salons/reserva', [ReservaSalonController::class, 'store'])->name('reservaSalons.store');
    Route::post('/salons/pago', [ReservaSalonController::class, 'pagado'])->name('reservaSalons.pagado');
    Route::get('/salons/reserva/edit/{salon}', [ReservaSalonController::class, 'edit'])->name('reservaSalons.edit')->middleware('admin');
    Route::patch('/salons/reserva/{salon}', [ReservaSalonController::class, 'update'])->name('reservaSalons.update')->middleware('admin');
    Route::delete('/salons/reserva/{salon}', [ReservaSalonController::class, 'destroy'])->name('reservaSalons.destroy');
    Route::get('/salons/reserva/facturaPdf', [ReservaSalonController::class, 'facturaPdf'])->name('reservaSalons.factura');
    Route::get('/salons/disponibilidad', function () {
        return view('admin.reservaSalons.disponibilidad');
    })->name('reservaSalons.disponibilidad')->middleware('admin');
    Route::post('/salons/disponibilidad', [ReservaSalonController::class, 'disponibilidad'])->name('reservaSalons.disponibilidad')->middleware('admin');

    // Rutas de gestión de imagenes de salones
    Route::get('/salons/imagenes', [ImagenSalonController::class, 'index'])->name('imagenSalons.index')->middleware('admin');
    Route::get('/salons/imagenes/create', [ImagenSalonController::class, 'create'])->name('imagenSalons.create')->middleware('admin');
    Route::post('/salons/imagenes', [ImagenSalonController::class, 'store'])->name('imagenSalons.store')->middleware('admin');
    Route::get('/salons/imagenes/edit/{salon}', [ImagenSalonController::class, 'edit'])->name('imagenSalons.edit')->middleware('admin');
    Route::post('/salons/imagenes/{salon}', [ImagenSalonController::class, 'update'])->name('imagenSalons.update')->middleware('admin');
    Route::delete('/salons/imagenes/{salon}', [ImagenSalonController::class, 'destroy'])->name('imagenSalons.destroy')->middleware('admin');


    // Rutas de gestión de reseñas
    Route::get('/resenas', [ResenaController::class, 'index'])->name('resenas.index')->middleware('admin');
    Route::post('/resenas', [ResenaController::class, 'store'])->name('resenas.store');
    Route::get('/resenas/edit/{resena}', [ResenaController::class, 'edit'])->name('resenas.edit')->middleware('admin');
    Route::patch('/resenas/{resena}', [ResenaController::class, 'update'])->name('resenas.update')->middleware('admin');
    Route::delete('/resenas/{resena}', [ResenaController::class, 'destroy'])->name('resenas.destroy')->middleware('admin');
});

// Ruta para cambiar el idioma de la aplicación
Route::get('/change-locale/{locale}', [LocaleController::class, 'changeLocale'])->name('change.locale');

// Rutas de autenticación generadas por Laravel
Auth::routes();

// Ruta de fallback, redirige a la página de inicio si no se encuentra la ruta solicitada
Route::fallback(function () {
    return redirect()->route('inicio');
});
