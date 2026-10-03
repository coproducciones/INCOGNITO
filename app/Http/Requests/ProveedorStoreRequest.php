<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProveedorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_usuario' => ['required', 'integer', 'exists:usuarios,id', Rule::unique('proveedor', 'id_usuario')],
            'especialidad' => ['required', 'string', 'max:150'],
            'telefono' => ['required', 'string', 'max:20'],
            'whatsapp' => ['nullable', 'string', 'max:20'],
            'descripcion' => ['nullable', 'string'],
            'foto_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
