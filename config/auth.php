<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | Define la configuración por defecto del guard y del broker de contraseñas.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuarios',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Aquí defines cómo se manejará la autenticación. 
    | Usamos el driver "session" y el provider "usuarios".
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | Aquí defines cómo se obtienen los usuarios desde tu base de datos.
    | En este caso, usas tu modelo App\Models\Usuario.
    |
    */

    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Reset de contraseñas
    |--------------------------------------------------------------------------
    |
    | Define el comportamiento del restablecimiento de contraseñas.
    |
    */

    'passwords' => [
        'usuarios' => [
            'provider' => 'usuarios',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Tiempo de confirmación de contraseña
    |--------------------------------------------------------------------------
    |
    | Cuánto tiempo (en segundos) la confirmación de contraseña será válida.
    | Por defecto, 3 horas.
    |
    */

    'password_timeout' => 10800,

];
