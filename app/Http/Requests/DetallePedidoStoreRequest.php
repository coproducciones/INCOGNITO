<?php

namespace App\Http\Requests\Pedidos;

use Illuminate\Foundation\Http\FormRequest;

class DetallePedidoStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id'
            ],

            'cantidad' => [
                'required',
                'integer',
                'min:1'
            ],
        ];
    }
}