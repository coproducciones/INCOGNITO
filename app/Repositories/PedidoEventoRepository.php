<?php

namespace App\Repositories;

use App\Models\PedidoEvento;

class PedidoEventoRepository
{
    public function allByPedido(int $pedidoId)
    {
        return PedidoEvento::with('estado')
            ->where('id_pedido', $pedidoId)
            ->orderByDesc('fecha')
            ->get();
    }

    public function create(array $data): PedidoEvento
    {
        return PedidoEvento::create($data);
    }
}