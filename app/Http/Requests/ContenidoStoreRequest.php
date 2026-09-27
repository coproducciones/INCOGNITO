<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContenidoStoreRequest extends FormRequest
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
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $this->validate([
                'titulo' => 'required|string|max:255',
                'categoria_id' => 'required|exists:categorias,id',
                'descripcion' => 'nullable|string',
            ]);
        });
    }
    
}
