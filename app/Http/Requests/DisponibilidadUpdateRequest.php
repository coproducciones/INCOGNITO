<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisponibilidadUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'fecha' => ['required', 'date'],
            'disponible' => ['required', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'fecha.required' => 'Debes seleccionar una fecha.',
            'fecha.date' => 'La fecha seleccionada no es válida.',
            'disponible.required' => 'Debes indicar si estarás disponible.',
            'disponible.boolean' => 'El valor de disponibilidad no es válido.',
        ];
    }
}
