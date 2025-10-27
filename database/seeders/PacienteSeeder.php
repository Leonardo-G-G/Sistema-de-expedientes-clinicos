<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Paciente;
use Carbon\Carbon;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $pacientes = [
            [
                'Nombre' => 'Carlos',
                'Apellido' => 'López',
                'Sexo' => 'Masculino',
                'Fecha_Nacimiento' => '1990-05-14',
                'Lugar_Origen' => 'Guadalajara',
                'Telefono' => '3312345678',
                'Contacto_Emergencia' => 'Maria López - 3311112222',
            ],
            [
                'Nombre' => 'Lucía',
                'Apellido' => 'Hernández',
                'Sexo' => 'Femenino',
                'Fecha_Nacimiento' => '1985-09-23',
                'Lugar_Origen' => 'Ciudad de México',
                'Telefono' => '5554321098',
                'Contacto_Emergencia' => 'Pedro Hernández - 5545671234',
            ],
            [
                'Nombre' => 'José',
                'Apellido' => 'Ramírez',
                'Sexo' => 'Masculino',
                'Fecha_Nacimiento' => '2000-01-30',
                'Lugar_Origen' => 'Puebla',
                'Telefono' => '2224567890',
                'Contacto_Emergencia' => 'Carmen Ramírez - 2229876543',
            ],
            [
                'Nombre' => 'Elena',
                'Apellido' => 'Gómez',
                'Sexo' => 'Femenino',
                'Fecha_Nacimiento' => '1998-12-10',
                'Lugar_Origen' => 'Monterrey',
                'Telefono' => '8187654321',
                'Contacto_Emergencia' => 'Luis Gómez - 8181112233',
            ],
            [
                'Nombre' => 'Miguel',
                'Apellido' => 'Torres',
                'Sexo' => 'Masculino',
                'Fecha_Nacimiento' => '1975-07-04',
                'Lugar_Origen' => 'Querétaro',
                'Telefono' => '4423332211',
                'Contacto_Emergencia' => 'Laura Torres - 4425556677',
            ],
        ];

        foreach ($pacientes as $paciente) {
            Paciente::create($paciente);
        }
    }
}
