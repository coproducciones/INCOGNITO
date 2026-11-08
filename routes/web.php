<?php

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;

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
use App\Http\Controllers\ProveedorPedidoController;

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
    $busqueda = trim((string) request()->query('q', ''));

    // Categorías con conteo de productos públicos y proveedores asociados.
    $categorias = Categoria::query()
        ->withCount([
            'productos' => function ($query) {
                $query->publicos();
            },
            'proveedores',
        ])
        ->orderBy('nombre')
        ->get();

    // Catálogo público de proveedores. La búsqueda y el filtro se aplican
    // tanto al nombre/especialidad como a la categoría seleccionada.
    $proveedores = Proveedor::query()
        ->with(['usuario', 'categorias'])
        ->whereHas('usuario')
        ->when($categoriaId !== null && $categoriaId !== '', function ($query) use ($categoriaId) {
            $query->whereHas('categorias', function ($categoriaQuery) use ($categoriaId) {
                $categoriaQuery->where('categorias.id', $categoriaId);
            });
        })
        ->when($busqueda !== '', function ($query) use ($busqueda) {
            $query->where(function ($filtro) use ($busqueda) {
                $filtro->where('especialidad', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%")
                    ->orWhereHas('usuario', function ($usuarioQuery) use ($busqueda) {
                        $usuarioQuery->where('nombre', 'like', "%{$busqueda}%");
                    })
                    ->orWhereHas('categorias', function ($categoriaQuery) use ($busqueda) {
                        $categoriaQuery->where('nombre', 'like', "%{$busqueda}%");
                    });
            });
        })
        ->orderBy('id_proveedor')
        ->paginate(6, ['*'], 'proveedores_page')
        ->withQueryString();

    // Productos públicos (activos y de proveedores vigentes).
    $productos = Producto::query()
        ->with(['categoria', 'media', 'proveedor'])
        ->publicos()
        ->when($categoriaId !== null && $categoriaId !== '', function ($query) use ($categoriaId) {
            $query->where('categoria_id', $categoriaId);
        })
        ->when($busqueda !== '', function ($query) use ($busqueda) {
            $query->where(function ($filtro) use ($busqueda) {
                $filtro->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%");
            });
        })
        ->orderBy('nombre')
        ->paginate(12, ['*'], 'productos_page')
        ->withQueryString();

    return view('servicios', compact(
        'categorias',
        'productos',
        'proveedores',
        'categoriaId',
        'busqueda'
    ));
})->name('servicios');

// Perfil público del proveedor, accesible sin iniciar sesión.
Route::get('/servicios/proveedor/{proveedor}', function (Proveedor $proveedor) {
    $proveedor->load(['usuario', 'categorias']);

    abort_unless($proveedor->usuario, 404);

    return view('Proveedores.public-show', compact('proveedor'));
})->whereNumber('proveedor')->name('servicios.proveedor');


/*
|--------------------------------------------------------------------------
| DETALLE PÚBLICO DE PRODUCTO
|--------------------------------------------------------------------------
*/

Route::get('/servicios/producto/{producto}', function (Producto $producto) {
    abort_unless(
        Producto::query()->publicos()->whereKey($producto->getKey())->exists(),
        404
    );

    $producto->load(['categoria', 'proveedor']);

    return view('servicios-detalle', compact('producto'));
})->name('servicios.detalle');


/*
|--------------------------------------------------------------------------
| CATEGORÍAS
|--------------------------------------------------------------------------
*/

Route::resource('categorias', CategoriaController::class)
    ->middlewareFor('index', 'permiso:categorias.ver')
    ->middlewareFor('show', 'permiso:categorias.ver')
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

// El listado administrativo (index) es solo para el administrador global.
// El proveedor gestiona sus productos desde /mis-productos.
Route::resource('productos', ProductoController::class)
    ->middlewareFor('index', 'permiso:proveedores.ver')
    ->middlewareFor('show', 'permiso:productos.ver')
    ->middlewareFor('create', 'permiso:productos.crear')
    ->middlewareFor('store', 'permiso:productos.crear')
    ->middlewareFor('edit', 'permiso:productos.editar')
    ->middlewareFor('update', 'permiso:productos.editar')
    ->middlewareFor('destroy', 'permiso:productos.eliminar');

Route::patch(
    'productos/{producto}/estado',
    [ProductoController::class, 'toggleEstado']
)
    ->middleware('permiso:productos.editar')
    ->name('productos.estado');

Route::get('/mis-productos', [ProductoController::class, 'misProductos'])
    ->middleware('permiso:productos.ver')
    ->name('mis-productos.index');


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
    ->middlewareFor('index', 'permiso:clientes.ver')
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
    ->middleware('permiso:dashboard.ver')
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
    ->middlewareFor('index', 'permiso:pedidos.admin.ver')
    ->middlewareFor('create', 'permiso:pedidos.admin.crear')
    ->middlewareFor('store', 'permiso:pedidos.admin.crear')
    ->middlewareFor('show', 'permiso:pedidos.admin.ver')
    ->middlewareFor('edit', 'permiso:pedidos.admin.editar')
    ->middlewareFor('update', 'permiso:pedidos.admin.editar')
    ->middlewareFor('destroy', 'permiso:pedidos.admin.eliminar');

Route::patch(
    'pedidos/{pedido}/estado',
    [PedidoController::class, 'updateEstado']
)
    ->middleware('permiso:pedidos.admin.editar')
    ->name('pedidos.estado.update');

Route::post(
    'pedidos/{pedido}/detalles',
    [DetallePedidoController::class, 'store']
)
    ->middleware('permiso:pedidos.admin.editar')
    ->name('pedidos.detalles.store');

Route::patch(
    'pedidos/{pedido}/detalles/{detalle}',
    [DetallePedidoController::class, 'update']
)
    ->middleware('permiso:pedidos.admin.editar')
    ->name('pedidos.detalles.update');

Route::delete(
    'pedidos/{pedido}/detalles/{detalle}',
    [DetallePedidoController::class, 'destroy']
)
    ->middleware('permiso:pedidos.admin.editar')
    ->name('pedidos.detalles.destroy');

Route::post(
    'pedidos/{pedido}/eventos',
    [PedidoEventoController::class, 'store']
)
    ->middleware('permiso:pedidos.admin.editar')
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
    ->middleware(['auth', 'permiso:proveedores.contactar'])
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

Route::middleware('auth')->group(function () {
    Route::get(
        '/mi-perfil-proveedor/crear',
        [ProveedorController::class, 'crearMiPerfil']
    )->name('proveedores.mi-perfil.create');

    Route::post(
        '/mi-perfil-proveedor',
        [ProveedorController::class, 'guardarMiPerfil']
    )->name('proveedores.mi-perfil.store');
});


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
    ->middleware('auth')
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
    ->except('show')
    ->middlewareFor('index', 'permiso:estados.ver')
    ->middlewareFor('create', 'permiso:estados.crear')
    ->middlewareFor('store', 'permiso:estados.crear')
    ->middlewareFor('edit', 'permiso:estados.editar')
    ->middlewareFor('update', 'permiso:estados.editar')
    ->middlewareFor('destroy', 'permiso:estados.eliminar');


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
        )->middleware('permiso:perfil.ver')->name('mi-cuenta.perfil');

        Route::get(
            '/perfil/editar',
            [UsuarioController::class, 'editProfile']
        )->middleware('permiso:perfil.editar')->name('mi-cuenta.perfil.edit');

        Route::put(
            '/perfil',
            [UsuarioController::class, 'updateProfile']
        )->middleware('permiso:perfil.editar')->name('mi-cuenta.perfil.update');

        Route::get(
            '/pedidos',
            [PedidoController::class, 'misPedidos']
        )->middleware('permiso:pedidos.ver')->name('mi-cuenta.pedidos');

        Route::get(
            '/pedidos/{pedido}',
            [PedidoController::class, 'miPedido']
        )->middleware('permiso:pedidos.ver')->name('mi-cuenta.pedidos.show');

        Route::delete(
            '/pedidos/{pedido}/cancelar',
            [PedidoController::class, 'cancelarMiPedido']
        )->middleware('permiso:pedidos.cancelar')->name('mi-cuenta.pedidos.cancelar');

        Route::patch(
            '/pedidos/{pedido}/detalles/{detalle}',
            [PedidoController::class, 'actualizarDetalleMiPedido']
        )->middleware('permiso:pedidos.editar')->name('mi-cuenta.pedidos.detalles.update');

        Route::delete(
            '/pedidos/{pedido}/detalles/{detalle}',
            [PedidoController::class, 'eliminarDetalleMiPedido']
        )->middleware('permiso:pedidos.editar')->name('mi-cuenta.pedidos.detalles.destroy');

        Route::get(
            '/resenas',
            [ReseñaController::class, 'misResenas']
        )->middleware('permiso:resenas.ver')->name('mi-cuenta.resenas');

        Route::get(
            '/resenas/create',
            [ReseñaController::class, 'createMiResena']
        )->middleware('permiso:resenas.crear')->name('mi-cuenta.resenas.create');

        Route::post(
            '/resenas',
            [ReseñaController::class, 'storeMiResena']
        )->middleware('permiso:resenas.crear')->name('mi-cuenta.resenas.store');

        Route::get(
            '/resenas/{reseña}/edit',
            [ReseñaController::class, 'editMiResena']
        )->middleware('permiso:resenas.editar')->name('mi-cuenta.resenas.edit');

        Route::put(
            '/resenas/{reseña}',
            [ReseñaController::class, 'updateMiResena']
        )->middleware('permiso:resenas.editar')->name('mi-cuenta.resenas.update');

        Route::delete(
            '/resenas/{reseña}',
            [ReseñaController::class, 'destroyMiResena']
        )->middleware('permiso:resenas.eliminar')->name('mi-cuenta.resenas.destroy');
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
    )->middleware('permiso:carrito.ver')->name('carrito.index');

    Route::post(
        '/carrito/confirmar',
        [CarritoController::class, 'confirmar']
    )->middleware('permiso:pedidos.crear')->name('carrito.confirmar');

    Route::post(
        '/carrito/{producto}',
        [CarritoController::class, 'add']
    )->middleware('permiso:carrito.crear')->name('carrito.add');

    Route::patch(
        '/carrito/{producto}',
        [CarritoController::class, 'update']
    )->middleware('permiso:carrito.editar')->name('carrito.update');

    Route::delete(
        '/carrito/{producto}',
        [CarritoController::class, 'remove']
    )->middleware('permiso:carrito.eliminar')->name('carrito.remove');

    Route::delete(
        '/carrito',
        [CarritoController::class, 'clear']
    )->middleware('permiso:carrito.eliminar')->name('carrito.clear');
});


/*
|--------------------------------------------------------------------------
| PANEL DE GESTIÓN
|--------------------------------------------------------------------------
*/

Route::view('/panel', 'dashboard.gestion')
    ->middleware('permiso:dashboard.ver')
    ->name('dashboard.gestion');


Route::middleware('auth')
    ->prefix('proveedor/pedidos')
    ->name('proveedor.pedidos.')
    ->group(function () {
        Route::get('/', [ProveedorPedidoController::class, 'index'])
            ->middleware('permiso:proveedor.pedidos.ver')
            ->name('index');
        Route::get('/{pedido}', [ProveedorPedidoController::class, 'show'])
            ->whereNumber('pedido')
            ->middleware('permiso:proveedor.pedidos.ver')
            ->name('show');
        Route::patch('/{pedido}/estado', [ProveedorPedidoController::class, 'updateEstado'])
            ->whereNumber('pedido')
            ->middleware('permiso:proveedor.pedidos.estado.actualizar')
            ->name('estado.update');
    });


/*
|--------------------------------------------------------------------------
| RESEÑAS DE LOS PRODUCTOS DEL PROVEEDOR
|--------------------------------------------------------------------------
|
| El proveedor consulta las opiniones de sus productos y responde.
| La propiedad del producto se vuelve a comprobar en ReseñaService.
|
*/

Route::middleware('auth')
    ->prefix('proveedor/resenas')
    ->name('proveedor.resenas.')
    ->group(function () {
        Route::get('/', [ReseñaController::class, 'resenasProveedor'])
            ->middleware('permiso:proveedor.resenas.responder')
            ->name('index');

        Route::patch('/{resena}/respuesta', [ReseñaController::class, 'responderComoProveedor'])
            ->whereNumber('resena')
            ->middleware('permiso:proveedor.resenas.responder')
            ->name('responder');
    });
