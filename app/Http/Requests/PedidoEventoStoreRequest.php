<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class PedidoEventoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_estado' => [
                'nullable',
                'integer',
                'exists:estado_general,id_estado'
            ],

            'tipo_evento' => [
                'required',
                'string',
                'max:50'
            ],

            'comentario' => [
                'nullable',
                'string',
                'max:2000'
            ],
        ];
    }
}