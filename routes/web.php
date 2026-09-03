<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;

/*
|--------------------------------------------------------------------------
| Rutas principales
|--------------------------------------------------------------------------
*/

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard.index');

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
use App\Http\Controllers\ProductoController;

Route::resource('productos', ProductoController::class);
/*
|--------------------------------------------------------------------------
| Usuarios
|--------------------------------------------------------------------------
*/
use App\Http\Controllers\UsuarioController;

Route::resource('usuarios', UsuarioController::class)
    ->parameters(['usuarios' => 'usuario']);
