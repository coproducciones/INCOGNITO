<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:100'],
            'empresa' => ['required', 'string', 'max:150'],
            'logo_url' => ['nullable', 'url', 'max:255'],
            'activo' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede superar los 100 caracteres.',
            'empresa.required' => 'La empresa es obligatoria.',
            'empresa.string' => 'La empresa debe ser texto.',
            'empresa.max' => 'La empresa no puede superar los 150 caracteres.',
            'logo_url.url' => 'La URL del logo no es válida.',
            'logo_url.max' => 'La URL del logo no puede superar los 255 caracteres.',
            'activo.required' => 'Debes indicar el estado del cliente.',
            'activo.boolean' => 'El estado del cliente no es válido.',
        ];
    }
}