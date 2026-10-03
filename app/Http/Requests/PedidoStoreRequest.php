<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoStoreRequest extends FormRequest
{
    /*
     * =========================================================
     * AUTORIZACIÓN
     * =========================================================
     */

    public function authorize(): bool
    {
        return true;
    }


    /*
     * =========================================================
     * REGLAS DE VALIDACIÓN
     * =========================================================
     */

    public function rules(): array
    {
        return [

            /*
             * Usuario responsable del pedido.
             */
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id',
            ],


            /*
             * La lista de productos es opcional.
             *
             * Esto permite crear un pedido vacío
             * y agregar productos posteriormente.
             */
            'productos' => [
                'nullable',
                'array',
            ],


            /*
             * Cada producto debe existir.
             */
            'productos.*.id_producto' => [
                'required',
                'integer',
                'exists:productos,id',
            ],


            /*
             * La cantidad debe ser mínimo 1.
             */
            'productos.*.cantidad' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }


    /*
     * =========================================================
     * MENSAJES
     * =========================================================
     */

    public function messages(): array
    {
        return [

            'id_usuario.required' =>
                'Debes seleccionar un usuario.',

            'id_usuario.exists' =>
                'El usuario seleccionado no existe.',

            'productos.array' =>
                'Los productos enviados no tienen un formato válido.',

            'productos.*.id_producto.required' =>
                'Debes seleccionar un producto.',

            'productos.*.id_producto.exists' =>
                'Uno de los productos seleccionados no existe.',

            'productos.*.cantidad.required' =>
                'Debes indicar la cantidad del producto.',

            'productos.*.cantidad.integer' =>
                'La cantidad debe ser un número entero.',

            'productos.*.cantidad.min' =>
                'La cantidad debe ser como mínimo 1.',
        ];
    }
}