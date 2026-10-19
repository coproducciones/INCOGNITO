<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioSeguridadUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $usuario = $this->route('usuario');

        return [
            'nombre' => [
                'required',
                'string',
                'max:120',
            ],

            'email' => [
                'required',
                'email',
                'max:150',
                Rule::unique('usuarios', 'email')
                    ->ignore($usuario->getKey()),
            ],

            'id_rol' => [
                'nullable',
                'integer',
                'exists:roles,id_rol',
            ],

            'id_estado' => [
                'required',
                'integer',
                Rule::exists('estado_general', 'id_estado')
                    ->where(fn ($query) =>
                        $query->where('tipo', 'USUARIO')
                    ),
            ],
        ];
    }
}
