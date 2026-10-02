<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pedidos\StorePedidoEventoRequest;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\RedirectResponse;

class PedidoEventoController extends Controller
{
    public function __construct(
        private PedidoService $service
    ) {}

    public function store(
        StorePedidoEventoRequest $request,
        Pedido $pedido
    ): RedirectResponse {

        $this->service->registrarEvento(
            $pedido,
            $request->validated()
        );

        return back()->with(
            'success',
            'Evento registrado en el historial.'
        );
    }
}