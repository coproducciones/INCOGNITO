<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RolStoreRequest extends FormRequest
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
        return [

            /*
             * Nombre del rol.
             */

            'nombre' => [
                'required',
                'string',
                'max:50',
                'unique:roles,nombre',
            ],


            /*
             * Lista de permisos.
             *
             * El campo puede estar vacío porque un rol podría
             * crearse inicialmente sin permisos.
             */

            'permisos' => [
                'nullable',
                'array',
            ],


            /*
             * Cada permiso seleccionado debe existir
             * en la tabla permisos.
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
                'Ya existe un rol con ese nombre.',

            'permisos.array' =>
                'Los permisos enviados no tienen un formato válido.',

            'permisos.*.exists' =>
                'Uno de los permisos seleccionados no existe.',
        ];
    }
}

