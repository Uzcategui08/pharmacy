<?php

use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\MedicamentosControllerAdmin;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\HomeControllerAdmin;

use App\Http\Controllers\ReportesControllerAdmin;
use App\Http\Controllers\FarmaciasControllerAdmin;
use App\Http\Controllers\AlmacenControllerAdmin;
use App\Http\Controllers\ApartadosAdmin;

require __DIR__ . '/auth.php';

/////rutas de inicio

Route::get('/', function () {
    return view('registro');
})->name('registro');

Route::get('/registro-admin', function () {
    return view('registro-admin');
})->name('registro-admin');

/////

/////rutas del cliente

/////

////rutas del administrador

/////

Route::get('/user/configuracion', function () {
    return view('user.configuracion');
})->name('user.configuracion');

Route::get('/admin/configuracion', function () {
    return view('admin.configuracion');
})->name('admin.configuracion');


//rutas para la modificacion de perfil
Route::middleware('auth')->group(function () {
    Route::get('user/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('user/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('user/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



//vista oficial de usuario administrador
Route::get('admin/dashboard', [UserController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');

Route::get('admin/medicamentos', [MedicamentoController::class, 'mostrarMedicamentos'])->middleware(['auth', 'admin'])->name('admin.medicamentos');

/* vista oficial de usuario cliente
Route::get('inicio', function () {
    return view('user.home');
})->middleware(['auth', 'verified'])->name('user.home');
*/
//vista oficial de usuario cliente
Route::get('user/home', [HomeController::class, 'index'])->middleware(['auth', 'verified', 'admin'])->name('user.home');

//agreagr middlware
Route::get('buscar', function () {
    return view('user.buscar');
})->middleware(['auth', 'verified'])->name('user.buscar');

Route::get('user/busqueda', [MedicamentoController::class, 'search'])
    ->middleware(['auth', 'verified'])->name('user.busqueda');

Route::get("user/carrito", [MedicamentoController::class, 'carrito'])
    ->middleware(['auth', 'verified'])->name('user.carrito');
//Route::get('user/medicamento/{id_medicamento}', [MedicamentoController::class, 'agregarCarrito'])->name('user.agregar.al.carrito');

//Route::patch('/actualizar-carrito/{id}', [MedicamentoController::class, 'actualizarCarrito'])->name('user.actualizar.carrito');

Route::post('user/agregar-carrito', [MedicamentoController::class, 'agregarCarrito'])->name('user.agregar.carrito');

Route::post('/carrito/update/{id}', [MedicamentoController::class, 'update'])->name('carrito.update');


Route::delete('/carrito/delete/{id}', [MedicamentoController::class, 'destroy'])->name('carrito.delete');

// En routes/web.php
Route::get('/carrito/count', [HomeController::class, 'getCartCount']);


Route::post('/realizar-apartado', [MedicamentoController::class, 'realizarApartado'])->name('realizar.apartado');

Route::get('/user/apartado', [MedicamentoController::class, 'mostrar'])->name('user.apartado');
Route::get('/apartados/{id}/detalles', [MedicamentoController::class, 'detalles']);

Route::put('/apartados/cancelar/{id}', [MedicamentoController::class, 'cancelar'])->name('apartados.cancelar');


Route::post('/wishlist/add/{id}', [MedicamentoController::class, 'addToWishlist'])->name('wishlist.add');
Route::delete('/wishlist/remove/{id}', [MedicamentoController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('user/wishlist', [MedicamentoController::class, 'showWishlist'])->name('wishlist.show');


/*
Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');
*/
/*
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
*/

/* administrador rutas */


Route::get('dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/edit', [ProfileController::class, 'edit'])->name('admin.edit');
    Route::patch('/admin/edit', [ProfileController::class, 'updateA'])->name('admin.update');
    Route::delete('/admin/edit', [ProfileController::class, 'destroyA'])->name('admin.destroy');
});

Route::resource('admin/crud/index', MedicamentosControllerAdmin::class)->middleware('auth');

Route::get('/admin/reportes/export', [ReportesControllerAdmin::class, 'index']);
Route::get('/admin/reportes/pdf', [ReportesControllerAdmin::class, 'exportPdf'])->name('export.pdf');

Route::get('admin/reportes/exportUser', [ReportesControllerAdmin::class, 'indexUser']);
Route::get('/admin/reportes/pdfUser', [ReportesControllerAdmin::class, 'exportPdf2'])->name('exportUser.pdfUser');

Route::get('admin/reportes/exportApartados', [ReportesControllerAdmin::class, 'indexApartados']);
Route::get('/admin/reportes/pdfApartados', [ReportesControllerAdmin::class, 'exportPdf3'])->name('exportApartados.pdfApartados');

Route::resource('admin/farmacia/farmacias', FarmaciasControllerAdmin::class)->middleware('auth');

Route::resource('/admin/almacen/almacen', AlmacenControllerAdmin::class);

Route::resource('admin/apartados/apartadosA', ApartadosAdmin::class)->middleware('auth');
Route::post('admin/apartados/apartadosA/{id}/aprobar', [ApartadosAdmin::class, 'aprobar'])->name('apartado.aprobar');

Route::get('admin/config', [UserController::class, 'User']);

require __DIR__ . '/auth.php';

route::get('admin/dashboard', [HomeControllerAdmin::class, "index"])->middleware(['auth', 'admin'])->name('admin.dashboard');

route::get('user/dashboard', [UserController::class, "index"])->middleware(['auth', 'verified', 'admin'])->name('user.dashboard');
