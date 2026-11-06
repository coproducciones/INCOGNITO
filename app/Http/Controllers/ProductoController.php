<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductoStoreRequest;
use App\Http\Requests\ProductoUpdateRequest;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Usuario;
use App\Services\ProductoService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductoController extends Controller
{
    public function __construct(private readonly ProductoService $service) {}

    /**
     * El administrador con permiso global ve todos los productos.
     * Un proveedor solo ve los productos de su propia ficha.
     */
    public function index(): View
    {
        $proveedor = $this->obtenerProveedorSiEsAccesoPersonal();
        $productos = $proveedor
            ? $this->service->getByProveedor($proveedor->id_proveedor)
            : $this->service->getAll();

        return view('Productos.index', compact('productos'));
    }

    public function create(): View
    {
        $proveedor = $this->obtenerProveedorSiEsAccesoPersonal();
        $categorias = Categoria::query()->orderBy('nombre')->get();
        $proveedores = $proveedor
            ? collect([$proveedor->load('usuario')])
            : Proveedor::with('usuario')->orderBy('id_proveedor')->get();

        return view('Productos.create', compact('categorias', 'proveedores'));
    }

    public function store(ProductoStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $proveedor = $this->obtenerProveedorSiEsAccesoPersonal();

        // La propiedad se determina desde la sesión, nunca desde el formulario.
        if ($proveedor !== null) {
            $data['id_proveedor'] = $proveedor->id_proveedor;
        }

        $data['activo'] = $request->boolean('activo');
        $this->service->create($data);

        return redirect($this->urlListado())
            ->with('success', 'Producto creado correctamente.');
    }

    public function show(Producto $producto): View
    {
        $this->autorizarProducto($producto);
        $producto->load(['categoria', 'proveedor.usuario']);

        return view('Productos.show', compact('producto'));
    }

    public function edit(Producto $producto): View
    {
        $this->autorizarProducto($producto);
        $proveedor = $this->obtenerProveedorSiEsAccesoPersonal();
        $categorias = Categoria::query()->orderBy('nombre')->get();
        $proveedores = $proveedor
            ? collect([$proveedor->load('usuario')])
            : Proveedor::with('usuario')->orderBy('id_proveedor')->get();

        return view('Productos.edit', compact('producto', 'categorias', 'proveedores'));
    }

    public function update(
        ProductoUpdateRequest $request,
        Producto $producto
    ): RedirectResponse {
        $this->autorizarProducto($producto);
        $data = $request->validated();
        $proveedor = $this->obtenerProveedorSiEsAccesoPersonal();

        // Un proveedor no puede transferir un producto a otra cuenta.
        if ($proveedor !== null) {
            $data['id_proveedor'] = $proveedor->id_proveedor;
        }

        $data['activo'] = $request->boolean('activo');
        $this->service->update($producto, $data);

        return redirect($this->urlListado())
            ->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto): RedirectResponse
    {
        $this->autorizarProducto($producto);
        $this->service->delete($producto);

        return redirect($this->urlListado())
            ->with('success', 'Producto eliminado correctamente.');
    }

    /**
     * Listado del proveedor con el diseño del catálogo (Servicios).
     * Muestra únicamente los productos de su propia ficha.
     */
    public function misProductos(): View|RedirectResponse
    {
        $usuario = Auth::user();
        abort_unless($usuario instanceof Usuario, 403);

        $proveedor = $usuario->proveedor()->first();

        if ($proveedor === null) {
            // El administrador sin ficha usa el listado administrativo.
            if ($usuario->esAdministradorGlobal()) {
                return redirect()->route('productos.index');
            }

            return redirect()
                ->route('proveedores.mi-perfil.create')
                ->with('error', 'Para gestionar productos primero completa tu perfil de proveedor.');
        }

        $productos = $this->service->getByProveedor($proveedor->id_proveedor);
        $productos->loadMissing('media');

        return view('Productos.mis-productos', compact('productos', 'proveedor'));
    }

    /**
     * Activa o desactiva un producto reutilizando el mismo servicio de
     * actualización (misma validación de proveedor y mismos campos).
     */
    public function toggleEstado(Producto $producto): RedirectResponse
    {
        $this->autorizarProducto($producto);

        $this->service->update($producto, [
            'categoria_id' => $producto->categoria_id,
            'id_proveedor' => $producto->id_proveedor,
            'nombre' => $producto->nombre,
            'descripcion' => $producto->descripcion,
            'precio' => $producto->precio,
            'stock' => $producto->stock,
            'activo' => ! $producto->activo,
        ]);

        return back()->with(
            'success',
            $producto->activo
                ? 'Producto activado correctamente.'
                : 'Producto desactivado correctamente.'
        );
    }

    /**
     * Destino tras guardar o eliminar: el administrador vuelve al listado
     * administrativo y el proveedor a su listado de productos.
     */
    private function urlListado(): string
    {
        $usuario = Auth::user();

        return $usuario instanceof Usuario && $usuario->esAdministradorGlobal()
            ? route('productos.index')
            : route('mis-productos.index');
    }

    /**
     * `proveedores.ver` representa el acceso global administrativo.
     * El resto de usuarios que utilicen este CRUD deben tener ficha propia.
     */
    private function obtenerProveedorSiEsAccesoPersonal(): ?Proveedor
    {
        $usuario = Auth::user();
        abort_unless($usuario instanceof Usuario, 403);

        if ($usuario->esAdministradorGlobal()) {
            return null;
        }

        $proveedor = $usuario->proveedor()->first();
        abort_unless($proveedor !== null, 403);

        return $proveedor;
    }

    private function autorizarProducto(Producto $producto): void
    {
        $proveedor = $this->obtenerProveedorSiEsAccesoPersonal();

        if ($proveedor !== null) {
            abort_unless(
                (int) $producto->id_proveedor === (int) $proveedor->id_proveedor,
                404
            );
        }
    }
}
