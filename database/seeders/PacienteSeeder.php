<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('paciente')->insert([
            [
                'Nombre' => 'Juan',
                'Apellido' => 'Pérez López',
                'Sexo' => 'Masculino',
                'Fecha_Nacimiento' => '1990-04-15',
                'Lugar_Origen' => 'Guadalajara, Jalisco',
                'Telefono' => '3312345678',
                'Contacto_Emergencia' => '3311223344',
            ],
            [
                'Nombre' => 'María',
                'Apellido' => 'González Ruiz',
                'Sexo' => 'Femenino',
                'Fecha_Nacimiento' => '1985-09-20',
                'Lugar_Origen' => 'Monterrey, Nuevo León',
                'Telefono' => '8187654321',
                'Contacto_Emergencia' => '8185544332',
            ],
            [
                'Nombre' => 'Luis',
                'Apellido' => 'Hernández Castro',
                'Sexo' => 'Masculino',
                'Fecha_Nacimiento' => '2000-01-10',
                'Lugar_Origen' => 'Ciudad de México',
                'Telefono' => '5511223344',
                'Contacto_Emergencia' => '5522334455',
            ],
            [
                'Nombre' => 'Ana',
                'Apellido' => 'Ramírez Torres',
                'Sexo' => 'Femenino',
                'Fecha_Nacimiento' => '1998-07-05',
                'Lugar_Origen' => 'Puebla, Puebla',
                'Telefono' => '2229876543',
                'Contacto_Emergencia' => '2228765432',
            ],
            [
                'Nombre' => 'Pedro',
                'Apellido' => 'Martínez Díaz',
                'Sexo' => 'Masculino',
                'Fecha_Nacimiento' => '1975-11-30',
                'Lugar_Origen' => 'Mérida, Yucatán',
                'Telefono' => '9995544332',
                'Contacto_Emergencia' => '9994433221',
            ],
        ]);
    }
}
