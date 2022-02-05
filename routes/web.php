<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProductoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('usuarios');
});

Route::resource('/usuario', UsuarioController::class);
Route::resource('/productos', ProductoController::class);

Route::get('/allProductos', [ProductoController::class, 'productosAll'])->name('allProductos');
Route::get('/editarProducto/{id}', [ProductoController::class, 'edit']);
Route::post('/desactivarProducto', [ProductoController::class, 'desactivarProducto']);

Route::get('/allUsuarios', [UsuarioController::class, 'usuariosAll'])->name('allUsuarios');
Route::post('/desactivarUsuario', [UsuarioController::class, 'desactivarUsuario']);
