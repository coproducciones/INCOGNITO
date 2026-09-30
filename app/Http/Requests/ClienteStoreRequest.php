<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteStoreRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado
     * para realizar esta petición.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Reglas de validación para crear un cliente.
     */
    public function rules(): array
    {
        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'empresa' => [
                'required',
                'string',
                'max:255',
            ],

            'logo_url' => [
                'nullable',
                'url',
                'max:500',
            ],

            'activo' => [
                'required',
                'boolean',
            ],
        ];
    }

    /**
     * Mensajes personalizados de validación.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede superar los 255 caracteres.',

            'empresa.required' => 'La empresa es obligatoria.',
            'empresa.string' => 'La empresa debe ser texto.',
            'empresa.max' => 'La empresa no puede superar los 255 caracteres.',

            'logo_url.url' => 'La URL del logo no es válida.',
            'logo_url.max' => 'La URL del logo es demasiado larga.',

            'activo.required' => 'Debes indicar el estado del cliente.',
            'activo.boolean' => 'El estado del cliente no es válido.',
        ];
    }
}
