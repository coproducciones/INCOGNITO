<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoPedidoUpdateRequest extends FormRequest
{
    /**
     * Determina si la solicitud está autorizada.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas para cambiar el estado de un pedido.
     */
    public function rules(): array
    {
        return [
            'id_estado' => [
                'required',
                'integer',
                'exists:estado_general,id_estado',
            ],

            'comentario' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ];
    }

    /**
     * Mensajes personalizados.
     */
    public function messages(): array
    {
        return [
            'id_estado.required' => 'Debes seleccionar un estado.',
            'id_estado.exists' => 'El estado seleccionado no existe.',
            'comentario.max' => 'El comentario no puede superar los 1000 caracteres.',
        ];
    }
}