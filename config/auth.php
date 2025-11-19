<?php

return [

    // Valores predeterminados
    'defaults' => [
        'guard' => 'web',
        'passwords' => 'usuarios',
    ],

    // Guards (método de autenticación)
    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'usuarios',
        ],
    ],

    // Providers (de dónde se obtienen los usuarios)
    'providers' => [
        'usuarios' => [
            'driver' => 'eloquent',
            'model' => App\Models\Usuario::class,
        ],
    ],

    // Ajustes para recuperación de contraseña
    'passwords' => [
        'usuarios' => [
            'provider' => 'usuarios',
            'table' => 'password_reset_tokens',
            'expire' => 60,      // Minutos antes de expirar el enlace
            'throttle' => 60,    // Minutos para reenviar otro email
        ],
    ],

    // Tiempo de expiración de confirmación de contraseña
    'password_timeout' => 10800,

];
