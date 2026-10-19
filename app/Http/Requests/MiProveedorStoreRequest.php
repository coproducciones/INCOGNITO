<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MiProveedorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'especialidad' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'descripcion' => ['nullable', 'string'],
            'foto_url' => ['nullable', 'url', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'especialidad.required' => 'Debes indicar tu especialidad.',
            'especialidad.max' => 'La especialidad no puede superar los 150 caracteres.',
            'telefono.required' => 'Debes registrar un teléfono de contacto.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'foto_url.url' => 'La foto debe tener una URL válida.',
        ];
    }
}
