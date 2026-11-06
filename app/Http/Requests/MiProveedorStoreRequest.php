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
            'categorias' => ['required', 'array', 'min:1'],
            'categorias.*' => ['required', 'integer', 'distinct', 'exists:categorias,id'],
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
            'categorias.required' => 'Selecciona al menos una categoría.',
            'categorias.min' => 'Selecciona al menos una categoría.',
            'categorias.*.exists' => 'Una de las categorías seleccionadas no es válida.',
            'especialidad.required' => 'Debes indicar tu especialidad específica.',
            'especialidad.max' => 'La especialidad no puede superar los 150 caracteres.',
            'telefono.required' => 'Debes registrar un teléfono de contacto.',
            'telefono.max' => 'El teléfono no puede superar los 20 caracteres.',
            'foto_url.url' => 'La foto debe tener una URL válida.',
        ];
    }
}
