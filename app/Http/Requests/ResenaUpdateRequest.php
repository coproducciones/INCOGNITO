<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResenaUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => [
                'required',
                'integer',
                'exists:usuarios,id',
            ],

            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id',
            ],

            'id_cliente' => [
                'required',
                'integer',
                'exists:clientes,id_cliente',
            ],

            'calificacion' => [
                'required',
                'integer',
                'between:1,5',
            ],

            'comentario' => [
                'nullable',
                'string',
            ],

            'respuesta' => [
                'nullable',
                'string',
            ],

            'fecha' => [
                'nullable',
                'date',
            ],
        ];
    }
}