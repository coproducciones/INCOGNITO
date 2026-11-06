<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespuestaResenaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check()
            && auth()->user()->tienePermiso('proveedor.resenas.responder');
    }

    public function rules(): array
    {
        return [
            'respuesta' => ['required', 'string', 'min:2', 'max:2000'],
        ];
    }

    public function messages(): array
    {
        return [
            'respuesta.required' => 'Escribe una respuesta antes de guardar.',
            'respuesta.min' => 'La respuesta debe contener al menos 2 caracteres.',
            'respuesta.max' => 'La respuesta no puede superar los 2000 caracteres.',
        ];
    }
}
