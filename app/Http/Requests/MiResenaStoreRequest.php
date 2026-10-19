<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiResenaStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'id_producto' => [
                'required',
                'integer',
                'exists:productos,id',
            ],
            'calificacion' => [
                'required',
                'integer',
                'between:1,5',
            ],
            'comentario' => [
                'nullable',
                'string',
                'max:2000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'id_producto.required' =>
                'Debes seleccionar un producto.',
            'id_producto.exists' =>
                'El producto seleccionado no existe.',
            'calificacion.required' =>
                'Debes seleccionar una calificación.',
            'calificacion.between' =>
                'La calificación debe estar entre 1 y 5.',
            'comentario.max' =>
                'El comentario no puede superar los 2000 caracteres.',
        ];
    }
}
