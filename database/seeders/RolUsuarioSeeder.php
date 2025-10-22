<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolUsuarioSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rol_usuario')->insert([
            [
                'Nombre' => 'Administrador',
                'Descripcion' => 'Usuario con acceso completo al sistema.',
            ],
            [
                'Nombre' => 'Médico',
                'Descripcion' => 'Usuario encargado de gestionar los pacientes y consultas.',
            ],
        ]);
    }
}
