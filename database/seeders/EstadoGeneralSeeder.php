<?php

namespace Database\Seeders;

use App\Models\EstadoGeneral;
use Illuminate\Database\Seeder;

class EstadoGeneralSeeder extends Seeder
{
    public function run(): void
    {
        $estados = [
            [
                'tipo' => 'PEDIDO',
                'nombre' => 'Pendiente',
            ],
            [
                'tipo' => 'PEDIDO',
                'nombre' => 'Confirmado',
            ],
            [
                'tipo' => 'PEDIDO',
                'nombre' => 'En proceso',
            ],
            [
                'tipo' => 'PEDIDO',
                'nombre' => 'Completado',
            ],
            [
                'tipo' => 'PEDIDO',
                'nombre' => 'Cancelado',
            ],

            [
                'tipo' => 'USUARIO',
                'nombre' => 'Activo',
            ],
            [
                'tipo' => 'USUARIO',
                'nombre' => 'Inactivo',
            ],

            [
                'tipo' => 'PAGO',
                'nombre' => 'Pendiente',
            ],
            [
                'tipo' => 'PAGO',
                'nombre' => 'Pagado',
            ],
            [
                'tipo' => 'PAGO',
                'nombre' => 'Rechazado',
            ],
        ];

        foreach ($estados as $estado) {
            EstadoGeneral::updateOrCreate(
                [
                    'tipo' => $estado['tipo'],
                    'nombre' => $estado['nombre'],
                ],
                $estado
            );
        }
    }
}