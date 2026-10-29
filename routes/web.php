<?php

use App\Models\Producto;
use App\Models\Categoria;

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
use App\Http\Controllers\EstadoGeneralController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SeguridadUsuarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\RegistroController;

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS
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
| SERVICIOS - CATÁLOGO PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/servicios', function () {
    $categoriaId = request()->query('categoria');

    $categorias = Categoria::withCount([
        'productos' => function ($query) {
            $query->where('activo', true);
        },
    ])
        ->orderBy('nombre')
        ->get();

    $productos = Producto::with(['categoria', 'media' => function ($query) {
        $query->whereNotNull('url')
            ->orderByDesc('destacado')
            ->orderByDesc('id');
    }])
        ->where('activo', true)
        ->when(
            $categoriaId !== null && $categoriaId !== '',
            function ($query) use ($categoriaId) {
                $query->where('categoria_id', $categoriaId);
            }
        )
        ->orderBy('nombre')
        ->paginate(12)
        ->withQueryString();

    return view('servicios', compact(
        'categorias',
        'productos',
        'categoriaId'
    ));
})->name('servicios');


/*
|--------------------------------------------------------------------------
| DETALLE PÚBLICO DE PRODUCTO
|--------------------------------------------------------------------------
*/

Route::get('/servicios/producto/{producto}', function (Producto $producto) {
    abort_unless($producto->activo, 404);

    $producto->load([
        'categoria',
        'media' => function ($query) {
            $query->whereNotNull('url')
                ->orderByDesc('destacado')
                ->orderByDesc('id');
        },
    ]);

    return view('servicios-detalle', compact('producto'));
})->name('servicios.detalle');

/*
|--------------------------------------------------------------------------
| CATEGORÍAS
|--------------------------------------------------------------------------
*/

Route::resource('categorias', CategoriaController::class)
    ->middlewareFor('create', 'permiso:categorias.crear')
    ->middlewareFor('store', 'permiso:categorias.crear')
    ->middlewareFor('edit', 'permiso:categorias.editar')
    ->middlewareFor('update', 'permiso:categorias.editar')
    ->middlewareFor('destroy', 'permiso:categorias.eliminar');


/*
|--------------------------------------------------------------------------
| PRODUCTOS
|--------------------------------------------------------------------------
*/

Route::resource('productos', ProductoController::class)
    ->middlewareFor('create', 'permiso:productos.crear')
    ->middlewareFor('store', 'permiso:productos.crear')
    ->middlewareFor('edit', 'permiso:productos.editar')
    ->middlewareFor('update', 'permiso:productos.editar')
    ->middlewareFor('destroy', 'permiso:productos.eliminar');


/*
|--------------------------------------------------------------------------
| USUARIOS
|--------------------------------------------------------------------------
*/

Route::resource('usuarios', UsuarioController::class)
    ->parameters([
        'usuarios' => 'usuario',
    ])
    ->middlewareFor('index', 'permiso:usuarios.ver')
    ->middlewareFor('create', 'permiso:usuarios.crear')
    ->middlewareFor('store', 'permiso:usuarios.crear')
    ->middlewareFor('show', 'permiso:usuarios.ver')
    ->middlewareFor('edit', 'permiso:usuarios.editar')
    ->middlewareFor('update', 'permiso:usuarios.editar')
    ->middlewareFor('destroy', 'permiso:usuarios.eliminar');


/*
|--------------------------------------------------------------------------
| CONTENIDO
|--------------------------------------------------------------------------
*/

Route::resource('contenidos', ContenidoController::class)
    ->middlewareFor('index', 'permiso:contenido.ver')
    ->middlewareFor('create', 'permiso:contenido.crear')
    ->middlewareFor('store', 'permiso:contenido.crear')
    ->middlewareFor('show', 'permiso:contenido.ver')
    ->middlewareFor('edit', 'permiso:contenido.editar')
    ->middlewareFor('update', 'permiso:contenido.editar')
    ->middlewareFor('destroy', 'permiso:contenido.eliminar');


/*
|--------------------------------------------------------------------------
| MULTIMEDIA
|--------------------------------------------------------------------------
*/

Route::resource('multimedias', MultimediaController::class)
    ->parameters([
        'multimedias' => 'media',
    ])
    ->middlewareFor('index', 'permiso:multimedia.ver')
    ->middlewareFor('create', 'permiso:multimedia.crear')
    ->middlewareFor('store', 'permiso:multimedia.crear')
    ->middlewareFor('show', 'permiso:multimedia.ver')
    ->middlewareFor('edit', 'permiso:multimedia.editar')
    ->middlewareFor('update', 'permiso:multimedia.editar')
    ->middlewareFor('destroy', 'permiso:multimedia.eliminar');


/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/

Route::resource('clientes', ClienteController::class)
    ->middlewareFor('index', 'permiso:usuarios.ver')
    ->middlewareFor('create', 'permiso:clientes.crear')
    ->middlewareFor('store', 'permiso:clientes.crear')
    ->middlewareFor('show', 'permiso:clientes.ver')
    ->middlewareFor('edit', 'permiso:clientes.editar')
    ->middlewareFor('update', 'permiso:clientes.editar')
    ->middlewareFor('destroy', 'permiso:clientes.eliminar');


/*
|--------------------------------------------------------------------------
| RESEÑAS ADMINISTRATIVAS
|--------------------------------------------------------------------------
*/

Route::resource('reseñas', ReseñaController::class)
    ->middlewareFor('index', 'permiso:resenas.ver')
    ->middlewareFor('create', 'permiso:resenas.crear')
    ->middlewareFor('store', 'permiso:resenas.crear')
    ->middlewareFor('show', 'permiso:resenas.ver')
    ->middlewareFor('edit', 'permiso:resenas.editar')
    ->middlewareFor('update', 'permiso:resenas.editar')
    ->middlewareFor('destroy', 'permiso:resenas.eliminar');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| PEDIDOS
|--------------------------------------------------------------------------
*/

Route::resource('pedidos', PedidoController::class)
    ->only([
        'index',
        'create',
        'store',
        'show',
        'edit',
        'update',
        'destroy',
    ])
    ->middlewareFor('index', 'permiso:pedidos.ver')
    ->middlewareFor('create', 'permiso:pedidos.crear')
    ->middlewareFor('store', 'permiso:pedidos.crear')
    ->middlewareFor('show', 'permiso:pedidos.ver')
    ->middlewareFor('edit', 'permiso:pedidos.editar')
    ->middlewareFor('update', 'permiso:pedidos.editar')
    ->middlewareFor('destroy', 'permiso:pedidos.cancelar');

Route::patch(
    'pedidos/{pedido}/estado',
    [PedidoController::class, 'updateEstado']
)
    ->middleware('permiso:pedidos.editar')
    ->name('pedidos.estado.update');

Route::post(
    'pedidos/{pedido}/detalles',
    [DetallePedidoController::class, 'store']
)
    ->middleware('permiso:pedidos.editar')
    ->name('pedidos.detalles.store');

Route::patch(
    'pedidos/{pedido}/detalles/{detalle}',
    [DetallePedidoController::class, 'update']
)
    ->middleware('permiso:pedidos.editar')
    ->name('pedidos.detalles.update');

Route::delete(
    'pedidos/{pedido}/detalles/{detalle}',
    [DetallePedidoController::class, 'destroy']
)
    ->middleware('permiso:pedidos.editar')
    ->name('pedidos.detalles.destroy');

Route::post(
    'pedidos/{pedido}/eventos',
    [PedidoEventoController::class, 'store']
)
    ->middleware('permiso:pedidos.editar')
    ->name('pedidos.eventos.store');


/*
|--------------------------------------------------------------------------
| WHATSAPP DEL PROVEEDOR
|--------------------------------------------------------------------------
*/

Route::get(
    'pedidos/{pedido}/whatsapp/{proveedor}',
    [PedidoController::class, 'whatsappProveedor']
)
    ->middleware('auth')
    ->name('pedidos.whatsapp.proveedor');


/*
|--------------------------------------------------------------------------
| PROVEEDORES
|--------------------------------------------------------------------------
*/

Route::resource('proveedores', ProveedorController::class)
    ->parameters([
        'proveedores' => 'proveedor',
    ])
    ->middlewareFor('index', 'permiso:proveedores.ver')
    ->middlewareFor('create', 'permiso:proveedores.crear')
    ->middlewareFor('store', 'permiso:proveedores.crear')
    ->middlewareFor('show', 'permiso:proveedores.ver')
    ->middlewareFor('edit', 'permiso:proveedores.editar')
    ->middlewareFor('update', 'permiso:proveedores.editar')
    ->middlewareFor('destroy', 'permiso:proveedores.eliminar');


/*
|--------------------------------------------------------------------------
| PERFIL DEL PROVEEDOR
|--------------------------------------------------------------------------
*/

Route::get(
    '/mi-perfil-proveedor/crear',
    [ProveedorController::class, 'crearMiPerfil']
)->name('proveedores.mi-perfil.create');

Route::post(
    '/mi-perfil-proveedor',
    [ProveedorController::class, 'guardarMiPerfil']
)->name('proveedores.mi-perfil.store');


/*
|--------------------------------------------------------------------------
| MI DISPONIBILIDAD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/mi-disponibilidad', [
        DisponibilidadController::class,
        'miIndex',
    ])
        ->middleware('permiso:disponibilidad.ver')
        ->name('mi-disponibilidad.index');

    Route::get('/mi-disponibilidad/crear', [
        DisponibilidadController::class,
        'miCreate',
    ])
        ->middleware('permiso:disponibilidad.crear')
        ->name('mi-disponibilidad.create');

    Route::post('/mi-disponibilidad', [
        DisponibilidadController::class,
        'miStore',
    ])
        ->middleware('permiso:disponibilidad.crear')
        ->name('mi-disponibilidad.store');

    Route::get('/mi-disponibilidad/{disponibilidad}/editar', [
        DisponibilidadController::class,
        'miEdit',
    ])
        ->middleware('permiso:disponibilidad.editar')
        ->name('mi-disponibilidad.edit');

    Route::put('/mi-disponibilidad/{disponibilidad}', [
        DisponibilidadController::class,
        'miUpdate',
    ])
        ->middleware('permiso:disponibilidad.editar')
        ->name('mi-disponibilidad.update');

    Route::delete('/mi-disponibilidad/{disponibilidad}', [
        DisponibilidadController::class,
        'miDestroy',
    ])
        ->middleware('permiso:disponibilidad.eliminar')
        ->name('mi-disponibilidad.destroy');
});


/*
|--------------------------------------------------------------------------
| DISPONIBILIDADES POR PROVEEDOR
|--------------------------------------------------------------------------
*/

Route::prefix('proveedores/{proveedor}')
    ->name('proveedores.')
    ->group(function () {
        Route::get(
            'disponibilidades',
            [DisponibilidadController::class, 'index']
        )
            ->middleware('permiso:disponibilidad.ver')
            ->name('disponibilidades.index');

        Route::get(
            'disponibilidades/create',
            [DisponibilidadController::class, 'create']
        )
            ->middleware('permiso:disponibilidad.crear')
            ->name('disponibilidades.create');

        Route::post(
            'disponibilidades',
            [DisponibilidadController::class, 'store']
        )
            ->middleware('permiso:disponibilidad.crear')
            ->name('disponibilidades.store');

        Route::get(
            'disponibilidades/{disponibilidad}/edit',
            [DisponibilidadController::class, 'edit']
        )
            ->middleware('permiso:disponibilidad.editar')
            ->name('disponibilidades.edit');

        Route::put(
            'disponibilidades/{disponibilidad}',
            [DisponibilidadController::class, 'update']
        )
            ->middleware('permiso:disponibilidad.editar')
            ->name('disponibilidades.update');

        Route::delete(
            'disponibilidades/{disponibilidad}',
            [DisponibilidadController::class, 'destroy']
        )
            ->middleware('permiso:disponibilidad.eliminar')
            ->name('disponibilidades.destroy');
    });


/*
|--------------------------------------------------------------------------
| SEGURIDAD DE USUARIOS
|--------------------------------------------------------------------------
*/

Route::prefix('seguridad')
    ->middleware('auth')
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('seguridad.usuarios.index');
        })->name('seguridad.index');

        Route::get(
            'usuarios',
            [SeguridadUsuarioController::class, 'index']
        )
            ->middleware('permiso:usuarios.ver')
            ->name('seguridad.usuarios.index');

        Route::get(
            'usuarios/{usuario}/edit',
            [SeguridadUsuarioController::class, 'edit']
        )
            ->middleware('permiso:usuarios.editar')
            ->name('seguridad.usuarios.edit');

        Route::put(
            'usuarios/{usuario}',
            [SeguridadUsuarioController::class, 'update']
        )
            ->middleware('permiso:usuarios.editar')
            ->name('seguridad.usuarios.update');
    });


/*
|--------------------------------------------------------------------------
| ROLES
|--------------------------------------------------------------------------
*/

Route::resource('roles', RolController::class)
    ->except('show')
    ->parameters([
        'roles' => 'rol',
    ])
    ->middlewareFor('index', 'permiso:roles.ver')
    ->middlewareFor('create', 'permiso:roles.crear')
    ->middlewareFor('store', 'permiso:roles.crear')
    ->middlewareFor('edit', 'permiso:roles.editar')
    ->middlewareFor('update', 'permiso:roles.editar')
    ->middlewareFor('destroy', 'permiso:roles.eliminar');

Route::get(
    'roles/{rol}/permisos',
    [RolController::class, 'permisos']
)
    ->middleware('permiso:roles.editar')
    ->name('roles.permisos');

Route::put(
    'roles/{rol}/permisos',
    [RolController::class, 'syncPermisos']
)
    ->middleware('permiso:roles.editar')
    ->name('roles.permisos.sync');


/*
|--------------------------------------------------------------------------
| PERMISOS
|--------------------------------------------------------------------------
*/

Route::resource('permisos', PermisoController::class)
    ->except('show')
    ->middlewareFor('index', 'permiso:permisos.ver')
    ->middlewareFor('create', 'permiso:permisos.crear')
    ->middlewareFor('store', 'permiso:permisos.crear')
    ->middlewareFor('edit', 'permiso:permisos.editar')
    ->middlewareFor('update', 'permiso:permisos.editar')
    ->middlewareFor('destroy', 'permiso:permisos.eliminar');


/*
|--------------------------------------------------------------------------
| ESTADOS GENERALES
|--------------------------------------------------------------------------
*/

Route::resource('estados', EstadoGeneralController::class)
    ->except('show');


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get(
        '/login',
        [UsuarioController::class, 'showLogin']
    )->name('login');

    Route::post(
        '/login',
        [UsuarioController::class, 'login']
    )->name('login.authenticate');

    Route::get(
        '/registro',
        [RegistroController::class, 'create']
    )->name('registro');

    Route::post(
        '/registro',
        [RegistroController::class, 'store']
    )
        ->middleware('throttle:6,1')
        ->name('registro.store');
});

Route::post(
    '/logout',
    [UsuarioController::class, 'logout']
)
    ->middleware('auth')
    ->name('logout');


/*
|--------------------------------------------------------------------------
| MI CUENTA Y MI PERFIL
|--------------------------------------------------------------------------
*/

Route::middleware('auth')
    ->prefix('mi-cuenta')
    ->group(function () {
        Route::get(
            '/',
            [UsuarioController::class, 'miCuenta']
        )->name('mi-cuenta');

        Route::get(
            '/perfil',
            [UsuarioController::class, 'perfil']
        )->name('mi-cuenta.perfil');

        Route::get(
            '/perfil/editar',
            [UsuarioController::class, 'editProfile']
        )->name('mi-cuenta.perfil.edit');

        Route::put(
            '/perfil',
            [UsuarioController::class, 'updateProfile']
        )->name('mi-cuenta.perfil.update');

        Route::get(
            '/pedidos',
            [PedidoController::class, 'misPedidos']
        )->name('mi-cuenta.pedidos');

        Route::get(
            '/pedidos/{pedido}',
            [PedidoController::class, 'miPedido']
        )->name('mi-cuenta.pedidos.show');

        Route::delete(
            '/pedidos/{pedido}/cancelar',
            [PedidoController::class, 'cancelarMiPedido']
        )->name('mi-cuenta.pedidos.cancelar');

        Route::patch(
            '/pedidos/{pedido}/detalles/{detalle}',
            [PedidoController::class, 'actualizarDetalleMiPedido']
        )->name('mi-cuenta.pedidos.detalles.update');

        Route::delete(
            '/pedidos/{pedido}/detalles/{detalle}',
            [PedidoController::class, 'eliminarDetalleMiPedido']
        )->name('mi-cuenta.pedidos.detalles.destroy');

        Route::get(
            '/resenas',
            [ReseñaController::class, 'misResenas']
        )->name('mi-cuenta.resenas');

        Route::get(
            '/resenas/create',
            [ReseñaController::class, 'createMiResena']
        )->name('mi-cuenta.resenas.create');

        Route::post(
            '/resenas',
            [ReseñaController::class, 'storeMiResena']
        )->name('mi-cuenta.resenas.store');

        Route::get(
            '/resenas/{reseña}/edit',
            [ReseñaController::class, 'editMiResena']
        )->name('mi-cuenta.resenas.edit');

        Route::put(
            '/resenas/{reseña}',
            [ReseñaController::class, 'updateMiResena']
        )->name('mi-cuenta.resenas.update');

        Route::delete(
            '/resenas/{reseña}',
            [ReseñaController::class, 'destroyMiResena']
        )->name('mi-cuenta.resenas.destroy');
    });


/*
|--------------------------------------------------------------------------
| CARRITO DE COMPRAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get(
        '/carrito',
        [CarritoController::class, 'index']
    )->name('carrito.index');

    Route::post(
        '/carrito/confirmar',
        [CarritoController::class, 'confirmar']
    )->name('carrito.confirmar');

    Route::post(
        '/carrito/{producto}',
        [CarritoController::class, 'add']
    )->name('carrito.add');

    Route::patch(
        '/carrito/{producto}',
        [CarritoController::class, 'update']
    )->name('carrito.update');

    Route::delete(
        '/carrito/{producto}',
        [CarritoController::class, 'remove']
    )->name('carrito.remove');

    Route::delete(
        '/carrito',
        [CarritoController::class, 'clear']
    )->name('carrito.clear');
});


/*
|--------------------------------------------------------------------------
| PANEL DE GESTIÓN
|--------------------------------------------------------------------------
*/

Route::view('/panel', 'dashboard.gestion')
    ->middleware('auth')
    ->name('dashboard.gestion');
