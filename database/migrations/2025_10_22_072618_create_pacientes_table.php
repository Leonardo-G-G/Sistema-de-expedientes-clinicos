<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('paciente', function (Blueprint $table) {
            $table->id('Id_Paciente');
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->enum('Sexo', ['Masculino', 'Femenino', 'Otro'])->nullable();
            $table->date('Fecha_Nacimiento')->nullable();
            $table->string('Lugar_Origen', 150)->nullable();
            $table->string('Telefono', 15)->nullable();
            $table->string('Contacto_Emergencia', 150)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
