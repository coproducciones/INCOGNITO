<?php

namespace App\Repositories;

use App\Models\Pedido;

class PedidoRepository
{
    public function all()
    {
        return Pedido::with([
            'usuario',
            'estado'
        ])
        ->withCount('detalles')
        ->orderByDesc('fecha_pedido')
        ->get();
    }

    public function find(int $id): Pedido
    {
        return Pedido::with([
            'usuario',
            'estado',
            'detalles.producto',
            'eventos.estado'
        ])->findOrFail($id);
    }

    public function create(array $data): Pedido
    {
        return Pedido::create($data);
    }

    public function update(
        Pedido $pedido,
        array $data
    ): Pedido {
        $pedido->update($data);

        return $pedido->refresh();
    }

    public function recalculateTotal(
        Pedido $pedido
    ): Pedido {
        $total = $pedido
            ->detalles()
            ->sum('subtotal');

        $pedido->update([
            'total' => $total
        ]);

        return $pedido->refresh();
    }
}