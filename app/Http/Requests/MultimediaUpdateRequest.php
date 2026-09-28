<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class MultimediaUpdateRequest extends FormRequest
{
    /*
    |--------------------------------------------------------------------------
    | Autorización
    |--------------------------------------------------------------------------
    */

    public function authorize(): bool
    {
        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | Reglas de validación
    |--------------------------------------------------------------------------
    */

    public function rules(): array
    {
        return [

            'url' => [
                'required',
                'url',
                'max:255',
            ],

            'tipo' => [
                'required',
                'string',
                'max:20',
            ],

            'destacado' => [
                'nullable',
                'boolean',
            ],

            'id_producto' => [
                'nullable',
                'integer',
                'exists:productos,id',
            ],

            /*
             * IMPORTANTE:
             * La tabla se llama "contenido".
             */
            'id_contenido' => [
                'nullable',
                'integer',
                'exists:contenido,id_contenido',
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Validación de asociación
    |--------------------------------------------------------------------------
    */

    public function withValidator($validator): void
    {
        $validator->after(function (Validator $validator) {

            $idProducto = $this->input('id_producto');
            $idContenido = $this->input('id_contenido');

            $tieneProducto =
                !is_null($idProducto) &&
                $idProducto !== '';

            $tieneContenido =
                !is_null($idContenido) &&
                $idContenido !== '';

            $cantidad = 0;

            if ($tieneProducto) {
                $cantidad++;
            }

            if ($tieneContenido) {
                $cantidad++;
            }

            if ($cantidad !== 1) {

                $validator->errors()->add(
                    'destino',
                    'La media debe estar asociada exactamente a un producto o a un contenido.'
                );
            }
        });
    }
}
