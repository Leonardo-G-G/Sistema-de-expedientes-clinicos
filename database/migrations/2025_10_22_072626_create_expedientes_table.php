<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expediente', function (Blueprint $table) {
            $table->id('Id_Expediente');
            $table->foreignId('Paciente_Id')->constrained('paciente', 'Id_Paciente');
            $table->foreignId('Medico_Id')->constrained('usuario', 'Id_Usuario');
            $table->timestamp('Fecha_Apertura')->useCurrent();
            $table->enum('Estado_Expediente', ['Activo', 'Inactivo', 'Cerrado'])->default('Activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediente');
    }
};
