<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstadoGeneralUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'tipo' => ['required','string','max:50'],
            'nombre' => ['required','string','max:50'],
        ];
    }
}
