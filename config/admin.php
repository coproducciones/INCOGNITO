<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Credenciales del administrador inicial
    |--------------------------------------------------------------------------
    |
    | Se utilizan únicamente para crear una cuenta administrativa nueva.
    | El seeder no modifica cuentas existentes.
    |
    */

    'name' => env('ADMIN_NAME', 'Administrador'),
    'email' => env('ADMIN_EMAIL'),
    'password' => env('ADMIN_PASSWORD'),
];
