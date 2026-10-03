<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisponibilidadStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_proveedor' => ['required', 'integer', 'exists:proveedor,id_proveedor'],
            'fecha' => [
                'required',
                'date',
                Rule::unique('disponibilidad', 'fecha')->where(
                    fn ($query) => $query->where('id_proveedor', $this->input('id_proveedor'))
                ),
            ],
            'disponible' => ['required', 'boolean'],
        ];
    }
}
