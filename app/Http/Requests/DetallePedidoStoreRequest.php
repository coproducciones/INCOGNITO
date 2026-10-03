<?php

namespace App\Http\Requests;

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
            /*
             * Producto que se agregará.
             */
            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id',
            ],

            /*
             * Cantidad solicitada.
             */
            'cantidad' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_producto.required' =>
                'Debes seleccionar un producto.',

            'id_producto.integer' =>
                'El producto seleccionado no es válido.',

            'id_producto.exists' =>
                'El producto seleccionado no existe.',

            'cantidad.required' =>
                'Debes indicar una cantidad.',

            'cantidad.integer' =>
                'La cantidad debe ser un número entero.',

            'cantidad.min' =>
                'La cantidad debe ser como mínimo 1.',
        ];
    }
}