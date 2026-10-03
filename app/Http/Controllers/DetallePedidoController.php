<?php

namespace App\Http\Controllers;

use App\Http\Requests\DetallePedidoStoreRequest;
use App\Http\Requests\DetallePedidoUpdateRequest;
use App\Models\Pedido;
use App\Services\PedidoService;
use Illuminate\Http\RedirectResponse;


class DetallePedidoController extends Controller
{
    public function __construct(
        private PedidoService $service
    ) {}

    public function store(
        DetallePedidoStoreRequest $request,
        Pedido $pedido
    ): RedirectResponse {

        $this->service->agregarDetalle(
            $pedido,
            $request->validated()
        );

        return back()->with(
            'success',
            'Producto agregado al pedido.'
        );
    }

    public function update(
        DetallePedidoUpdateRequest $request,
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {

        $this->service->modificarDetalle(
            $pedido,
            $detalle,
            $request->validated()
        );

        return back()->with(
            'success',
            'Cantidad actualizada.'
        );
    }

    public function destroy(
        Pedido $pedido,
        int $detalle
    ): RedirectResponse {

        $this->service->eliminarDetalle(
            $pedido,
            $detalle
        );

        return back()->with(
            'success',
            'Detalle eliminado.'
        );
    }
}