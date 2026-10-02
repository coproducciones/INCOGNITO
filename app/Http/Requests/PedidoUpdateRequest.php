<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoUpdateRequest extends FormRequest
{
    /**
     * Determina si la solicitud está autorizada.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas para actualizar un pedido.
     */
    public function rules(): array
    {
        return [
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id',
            ],

            'id_estado' => [
                'required',
                'integer',
                'exists:estado_general,id_estado',
            ],

            'fecha_pedido' => [
                'required',
                'date',
            ],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Debes seleccionar un usuario.',
            'id_usuario.exists' => 'El usuario seleccionado no existe.',

            'id_estado.required' => 'Debes seleccionar un estado.',
            'id_estado.exists' => 'El estado seleccionado no existe.',

            'fecha_pedido.required' => 'La fecha del pedido es obligatoria.',
            'fecha_pedido.date' => 'La fecha del pedido no es válida.',
        ];
    }
}