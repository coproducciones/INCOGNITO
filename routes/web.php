<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\MultimediaController;


/*
|--------------------------------------------------------------------------
| Rutas principales
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard.index');

Route::get('/nuestro-trabajo', function () {
    return view('nuestro-trabajo');
})->name('nuestro.trabajo');

Route::get('/nuestra-historia', function () {
    return view('nuestra-historia');
})->name('nuestra.historia');


/*
|--------------------------------------------------------------------------
| Categorías
|--------------------------------------------------------------------------
*/

Route::resource('categorias', CategoriaController::class);


/*
|--------------------------------------------------------------------------
| Productos
|--------------------------------------------------------------------------
*/

Route::resource('productos', ProductoController::class);


/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/

Route::resource('usuarios', UsuarioController::class)
    ->parameters([
        'usuarios' => 'usuario',
    ]);


/*
|--------------------------------------------------------------------------
| Contenido
|--------------------------------------------------------------------------
*/

Route::resource('contenidos', ContenidoController::class);


/*
|--------------------------------------------------------------------------
| Multimedia
|--------------------------------------------------------------------------
*/

Route::resource('multimedias', MultimediaController::class)
    ->parameters([ 'multimedias' => 'media', ]);
