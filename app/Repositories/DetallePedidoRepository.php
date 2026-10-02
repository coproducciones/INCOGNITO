<?php

namespace App\Repositories;

use App\Models\DetallePedido;
use App\Models\Pedido;

class DetallePedidoRepository
{
    public function create(array $data): DetallePedido
    {
        return DetallePedido::create($data);
    }

    public function find(int $id): DetallePedido
    {
        return DetallePedido::with('producto')
            ->findOrFail($id);
    }

    public function update(
        DetallePedido $detalle,
        array $data
    ): DetallePedido {
        $detalle->update($data);

        return $detalle->refresh();
    }

    public function delete(
        DetallePedido $detalle
    ): void {
        $detalle->delete();
    }

    public function belongsToPedido(
        DetallePedido $detalle,
        Pedido $pedido
    ): bool {
        return (int) $detalle->id_pedido ===
               (int) $pedido->id_pedido;
    }
}