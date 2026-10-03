<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DisponibilidadUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $disponibilidad = $this->route('disponibilidad');
        $id = is_object($disponibilidad) ? $disponibilidad->id_disponibilidad : $disponibilidad;
        $idProveedor = $this->input('id_proveedor');

        return [
            'id_proveedor' => ['required', 'integer', 'exists:proveedor,id_proveedor'],
            'fecha' => [
                'required',
                'date',
                Rule::unique('disponibilidad', 'fecha')
                    ->where(fn ($query) => $query->where('id_proveedor', $idProveedor))
                    ->ignore($id, 'id_disponibilidad'),
            ],
            'disponible' => ['required', 'boolean'],
        ];
    }
}
