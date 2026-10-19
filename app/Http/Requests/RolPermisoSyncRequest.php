<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolPermisoSyncRequest extends FormRequest
{
    public function authorize(): bool { return true; }
    public function rules(): array
    {
        return [
            'permisos' => ['nullable','array'],
            'permisos.*' => ['integer','exists:permisos,id_permiso'],
        ];
    }
}
