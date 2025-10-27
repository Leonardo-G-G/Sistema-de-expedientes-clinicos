<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::create([
            'Nombre' => 'Leonardo',
            'Apellido' => 'Martínez',
            'Correo_Electronico' => 'admin@clinica.com',
            'Contraseña' => Hash::make('12345678'),
            'Cedula_Profesional' => 'ABC12345',
            'Especialidad' => 'Medicina General',
        ]);

        Usuario::create([
            'Nombre' => 'Ana',
            'Apellido' => 'García',
            'Correo_Electronico' => 'ana@clinica.com',
            'Contraseña' => Hash::make('12345678'),
            'Cedula_Profesional' => 'MED98765',
            'Especialidad' => 'Pediatría',
        ]);
    }
}
