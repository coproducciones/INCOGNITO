<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermisoUpdateRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'nombre' => ['required','string','max:100'],
            'modulo' => ['required','string','max:50'],
        ];
    }
}
