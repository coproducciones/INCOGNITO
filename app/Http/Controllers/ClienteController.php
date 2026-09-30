<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteStoreRequest;
use App\Http\Requests\ClienteUpdateRequest;
use App\Models\Cliente;
use App\Services\ClienteService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ClienteController extends Controller
{
    /**
     * Servicio encargado de la lógica de negocio de los clientes.
     */
    public function __construct(
        private ClienteService $service
    ) {
    }

    /**
     * Muestra el listado de clientes.
     */
    public function index(): View
    {
        $clientes = $this->service->getAll();

        return view('Clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un cliente.
     */
    public function create(): View
    {
        return view('Clientes.create');
    }

    /**
     * Almacena un nuevo cliente.
     */
    public function store(ClienteStoreRequest $request): RedirectResponse
    {
        $this->service->create(
            $request->validated()
        );

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente creado correctamente.');
    }

    /**
     * Muestra los detalles de un cliente.
     */
    public function show(Cliente $cliente): View
    {
        return view('Clientes.show', compact('cliente'));
    }

    /**
     * Muestra el formulario para editar un cliente.
     */
    public function edit(Cliente $cliente): View
    {
        return view('Clientes.edit', compact('cliente'));
    }

    /**
     * Actualiza los datos de un cliente.
     */
    public function update(
        ClienteUpdateRequest $request,
        Cliente $cliente
    ): RedirectResponse {
        $this->service->update(
            $cliente,
            $request->validated()
        );

        return redirect()
            ->route('clientes.show', $cliente)
            ->with('success', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente.
     */
    public function destroy(Cliente $cliente): RedirectResponse
    {
        $this->service->delete($cliente);

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}
