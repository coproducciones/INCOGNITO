<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContenidoUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titulo' => ['required', 'string', 'max:150'],
            'descripcion' => ['nullable', 'string'],
            'seccion' => ['required', 'string', 'max:100'],
        ];
    }
}
