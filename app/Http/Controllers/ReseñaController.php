<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResenaStoreRequest;
use App\Http\Requests\ResenaUpdateRequest;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Reseña;
use App\Models\Usuario;
use App\Services\ReseñaService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReseñaController extends Controller
{
    /**
     * Servicio encargado de la lógica de negocio
     * de las reseñas.
     */
    public function __construct(
        private ReseñaService $service
    ) {
    }

    /**
     * Muestra todas las reseñas.
     */
    public function index(): View
    {
        $resenas = $this->service->getAll();

        return view(
            'Reseñas.index',
            compact('resenas')
        );
    }

    /**
     * Muestra el formulario para crear una reseña.
     */
    public function create(): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        $productos = Producto::orderBy('nombre')->get();

        $clientes = Cliente::orderBy('nombre')->get();

        return view(
            'Reseñas.create',
            compact(
                'usuarios',
                'productos',
                'clientes'
            )
        );
    }

    /**
     * Guarda una nueva reseña.
     */
    public function store(
        ResenaStoreRequest $request
    ): RedirectResponse {

        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('reseñas.index')
            ->with(
                'success',
                'Reseña creada correctamente.'
            );
    }

    /**
     * Muestra una reseña específica.
     */
    public function show(Reseña $reseña): View
    {
        /*
         * Buscamos nuevamente la reseña mediante
         * el servicio para cargar sus relaciones:
         *
         * usuario
         * producto
         * cliente
         */
        $reseña = $this->service->getById(
            $reseña->getKey()
        );

        /*
         * IMPORTANTE:
         *
         * La variable enviada a Blade se llama
         * exactamente $reseña.
         */
        return view(
            'Reseñas.show',
            compact('reseña')
        );
    }

    /**
     * Muestra el formulario para editar una reseña.
     */
    public function edit(Reseña $reseña): View
    {
        $reseña = $this->service->getById(
            $reseña->getKey()
        );

        $usuarios = Usuario::orderBy('nombre')->get();

        $productos = Producto::orderBy('nombre')->get();

        $clientes = Cliente::orderBy('nombre')->get();

        return view(
            'Reseñas.edit',
            compact(
                'reseña',
                'usuarios',
                'productos',
                'clientes'
            )
        );
    }

    /**
     * Actualiza una reseña.
     */
    public function update(
        ResenaUpdateRequest $request,
        Reseña $reseña
    ): RedirectResponse {

        $this->service->update(
            $reseña,
            $request->validated()
        );

        return redirect()
            ->route(
                'reseñas.show',
                $reseña
            )
            ->with(
                'success',
                'Reseña actualizada correctamente.'
            );
    }

    /**
     * Elimina una reseña.
     */
    public function destroy(
        Reseña $reseña
    ): RedirectResponse {

        $this->service->delete($reseña);

        return redirect()
            ->route('reseñas.index')
            ->with(
                'success',
                'Reseña eliminada correctamente.'
            );
    }
}

