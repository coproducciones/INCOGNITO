<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductoStoreRequest;
use App\Http\Requests\ProductoUpdateRequest;
use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Proveedor;
use App\Services\ProductoService;

class ProductoController extends Controller
{
    /**
     * =========================================================
     * SERVICIO
     * =========================================================
     */

    protected ProductoService $service;

    public function __construct(ProductoService $service)
    {
        $this->service = $service;
    }


    /**
     * =========================================================
     * LISTAR PRODUCTOS
     * =========================================================
     *
     * Esta página es PÚBLICA.
     *
     * Visitantes:
     * - pueden ver productos
     *
     * Usuarios autenticados:
     * - pueden ver productos
     *
     * Administradores:
     * - pueden ver productos
     */

    public function index()
    {
        $productos = $this->service->getAll();

        return view(
            'Productos.index',
            compact('productos')
        );
    }


    /**
     * =========================================================
     * FORMULARIO CREAR
     * =========================================================
     *
     * Protegido por:
     *
     * permiso:productos.crear
     */

    public function create()
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $proveedores = Proveedor::with('usuario')->orderBy('id_proveedor')->get();

        return view(
            'Productos.create',
            compact('categorias', 'proveedores')
        );
    }


    /**
     * =========================================================
     * GUARDAR PRODUCTO
     * =========================================================
     *
     * Protegido por:
     *
     * permiso:productos.crear
     */

    public function store(ProductoStoreRequest $request)
    {
        $data = $request->validated();

        /*
         * Checkbox "activo".
         *
         * Si viene marcado:
         * true
         *
         * Si no viene:
         * false
         */

        $data['activo'] = $request->boolean('activo');

        $this->service->create($data);

        return redirect()
            ->route('productos.index')
            ->with(
                'success',
                'Producto creado correctamente.'
            );
    }


    /**
     * =========================================================
     * MOSTRAR PRODUCTO
     * =========================================================
     *
     * Esta página es PÚBLICA.
     */

    public function show(Producto $producto)
    {
        $producto->load(['categoria', 'proveedor.usuario']);

        return view(
            'Productos.show',
            compact('producto')
        );
    }


    /**
     * =========================================================
     * FORMULARIO EDITAR
     * =========================================================
     *
     * Protegido por:
     *
     * permiso:productos.editar
     */

    public function edit(Producto $producto)
    {
        $categorias = Categoria::orderBy('nombre')->get();
        $proveedores = Proveedor::with('usuario')->orderBy('id_proveedor')->get();

        return view(
            'Productos.edit',
            compact(
                'producto',
                'categorias',
                'proveedores'
            )
        );
    }


    /**
     * =========================================================
     * ACTUALIZAR PRODUCTO
     * =========================================================
     *
     * Protegido por:
     *
     * permiso:productos.editar
     */

    public function update(
        ProductoUpdateRequest $request,
        Producto $producto
    ) {
        $data = $request->validated();

        /*
         * Checkbox "activo".
         */

        $data['activo'] = $request->boolean('activo');

        $this->service->update(
            $producto,
            $data
        );

        return redirect()
            ->route('productos.index')
            ->with(
                'success',
                'Producto actualizado correctamente.'
            );
    }


    /**
     * =========================================================
     * ELIMINAR PRODUCTO
     * =========================================================
     *
     * Protegido por:
     *
     * permiso:productos.eliminar
     */

    public function destroy(Producto $producto)
    {
        $this->service->delete($producto);

        return redirect()
            ->route('productos.index')
            ->with(
                'success',
                'Producto eliminado correctamente.'
            );
    }
}
