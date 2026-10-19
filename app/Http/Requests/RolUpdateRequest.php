<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RolUpdateRequest extends FormRequest
{
    /*
    |--------------------------------------------------------------------------
    | AUTORIZACIÓN
    |--------------------------------------------------------------------------
    */

    public function authorize(): bool
    {
        return true;
    }


    /*
    |--------------------------------------------------------------------------
    | REGLAS DE VALIDACIÓN
    |--------------------------------------------------------------------------
    */

    public function rules(): array
    {
        /*
         * Obtenemos el ID del rol que estamos editando.
         */

        $rolId = $this->route('rol')?->id_rol;


        return [

            /*
             * Nombre del rol.
             *
             * Ignoramos el propio rol al comprobar
             * que el nombre sea único.
             */

            'nombre' => [
                'required',
                'string',
                'max:50',
                Rule::unique('roles', 'nombre')
                    ->ignore($rolId, 'id_rol'),
            ],


            /*
             * Permisos seleccionados.
             */

            'permisos' => [
                'nullable',
                'array',
            ],


            /*
             * Cada permiso debe existir.
             */

            'permisos.*' => [
                'integer',
                'exists:permisos,id_permiso',
            ],
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | MENSAJES PERSONALIZADOS
    |--------------------------------------------------------------------------
    */

    public function messages(): array
    {
        return [

            'nombre.required' =>
                'El nombre del rol es obligatorio.',

            'nombre.max' =>
                'El nombre del rol no puede superar los 50 caracteres.',

            'nombre.unique' =>
                'Ya existe otro rol con ese nombre.',

            'permisos.array' =>
                'Los permisos enviados no tienen un formato válido.',

            'permisos.*.exists' =>
                'Uno de los permisos seleccionados no existe.',
        ];
    }
}

