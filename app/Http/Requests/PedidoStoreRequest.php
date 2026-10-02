<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoStoreRequest extends FormRequest
{
    /**
     * Determina si la solicitud está autorizada.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear un pedido.
     */
    public function rules(): array
    {
        return [
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id',
            ],
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'id_usuario.required' => 'Debes seleccionar un usuario.',
            'id_usuario.integer' => 'El usuario seleccionado no es válido.',
            'id_usuario.exists' => 'El usuario seleccionado no existe.',
        ];
    }
}