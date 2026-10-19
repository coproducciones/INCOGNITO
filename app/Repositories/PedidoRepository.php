<?php

namespace App\Repositories;

use App\Models\Pedido;

class PedidoRepository
{
    /*
     * =========================================================
     * OBTENER TODOS LOS PEDIDOS
     * =========================================================
     */

    public function all()
    {
        return Pedido::with([
            'usuario',
            'estado',
        ])
            ->withCount('detalles')
            ->orderByDesc('fecha_pedido')
            ->get();
    }


    /*
     * =========================================================
     * OBTENER UN PEDIDO COMPLETO
     *
     * Se cargan:
     *
     * Pedido
     *   ├── Usuario
     *   ├── Estado
     *   ├── Detalles
     *   │     └── Producto
     *   │           └── Categoría
     *   │
     *   └── Eventos
     *         └── Estado
     * =========================================================
     */

    public function find(int $id): Pedido
    {
        return Pedido::with([
            'usuario',
            'estado',

            'detalles.producto.categoria',

            'eventos.estado',
        ])
            ->findOrFail($id);
    }


    /*
     * =========================================================
     * CREAR PEDIDO
     * =========================================================
     */

    public function create(array $data): Pedido
    {
        return Pedido::create($data);
    }


    /*
     * =========================================================
     * ACTUALIZAR PEDIDO
     * =========================================================
     */

    public function update(
        Pedido $pedido,
        array $data
    ): Pedido {

        $pedido->update($data);

        return $pedido->refresh();
    }


    /*
     * =========================================================
     * RECALCULAR TOTAL
     *
     * Suma todos los subtotales.
     * =========================================================
     */

    public function recalculateTotal(
        Pedido $pedido
    ): Pedido {

        $total = $pedido
            ->detalles()
            ->sum('subtotal');

        $pedido->update([
            'total' => $total,
        ]);

        return $pedido->refresh();
    }

    /**
     * Obtiene solamente los pedidos del usuario autenticado.
     */
    public function forUsuario(int $usuarioId)
    {
        return Pedido::with([
            'usuario',
            'estado',
        ])
            ->withCount('detalles')
            ->where('id_usuario', $usuarioId)
            ->orderByDesc('fecha_pedido')
            ->get();
    }

    /**
     * Obtiene un pedido solamente si pertenece al usuario indicado.
     */
    public function findForUsuario(int $pedidoId, int $usuarioId): Pedido
    {
        return Pedido::with([
            'usuario',
            'estado',
            'detalles.producto.categoria',
            'eventos.estado',
        ])
            ->where('id_usuario', $usuarioId)
            ->findOrFail($pedidoId);
    }

}