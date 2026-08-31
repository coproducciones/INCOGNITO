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