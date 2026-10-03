<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ContenidoController;
use App\Http\Controllers\MultimediaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReseñaController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\DetallePedidoController;
use App\Http\Controllers\PedidoEventoController;
use App\Http\Controllers\DisponibilidadController;
use App\Http\Controllers\ProveedorController;
use Illuminate\Support\Facades\Route;

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
/*
|--------------------------------------------------------------------------
| Clientes
|--------------------------------------------------------------------------
*/

Route::resource('clientes', ClienteController::class);

/*
|--------------------------------------------------------------------------
| Reseñas
|--------------------------------------------------------------------------
*/
Route::resource('reseñas',ReseñaController::class);


/*
|--------------------------------------------------------------------------
| Reseñas
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

// CRUD principal de pedidos
Route::resource('pedidos', PedidoController::class)
    ->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ]);

// Cambiar el estado de un pedido
Route::patch(
    'pedidos/{pedido}/estado',
    [PedidoController::class, 'updateEstado']
)->name('pedidos.estado.update');

// Agregar detalles
Route::post(
    'pedidos/{pedido}/detalles',
    [DetallePedidoController::class, 'store']
)->name('pedidos.detalles.store');

// Modificar detalles
Route::patch(
    'pedidos/{pedido}/detalles/{detalle}',
    [DetallePedidoController::class, 'update']
)->name('pedidos.detalles.update');

// Eliminar detalles
Route::delete(
    'pedidos/{pedido}/detalles/{detalle}',
    [DetallePedidoController::class, 'destroy']
)->name('pedidos.detalles.destroy');

// Registrar eventos
Route::post(
    'pedidos/{pedido}/eventos',
    [PedidoEventoController::class, 'store']
)->name('pedidos.eventos.store');

/*
|--------------------------------------------------------------------------
| Proveedores
|--------------------------------------------------------------------------
*/

Route::resource('proveedores', ProveedorController::class)
    ->parameters([
        'proveedores' => 'proveedor',
    ]);


/*
|--------------------------------------------------------------------------
| Disponibilidades de proveedores
|--------------------------------------------------------------------------
*/

Route::prefix('proveedores/{proveedor}')
    ->name('proveedores.')
    ->group(function () {

        /*
         * Listar disponibilidades
         */
        Route::get(
            'disponibilidades',
            [DisponibilidadController::class, 'index']
        )->name('disponibilidades.index');


        /*
         * Crear disponibilidad
         */
        Route::get(
            'disponibilidades/create',
            [DisponibilidadController::class, 'create']
        )->name('disponibilidades.create');


        /*
         * Guardar disponibilidad
         */
        Route::post(
            'disponibilidades',
            [DisponibilidadController::class, 'store']
        )->name('disponibilidades.store');


        /*
         * Editar disponibilidad
         */
        Route::get(
            'disponibilidades/{disponibilidad}/edit',
            [DisponibilidadController::class, 'edit']
        )->name('disponibilidades.edit');


        /*
         * Actualizar disponibilidad
         */
        Route::put(
            'disponibilidades/{disponibilidad}',
            [DisponibilidadController::class, 'update']
        )->name('disponibilidades.update');


        /*
         * Eliminar disponibilidad
         */
        Route::delete(
            'disponibilidades/{disponibilidad}',
            [DisponibilidadController::class, 'destroy']
        )->name('disponibilidades.destroy');
    });