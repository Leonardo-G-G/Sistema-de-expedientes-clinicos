<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('expediente', function (Blueprint $table) {
            $table->id('Id_Expediente');

            // 🔗 Un paciente solo puede tener un expediente
            $table->foreignId('Paciente_Id')
                  ->unique()
                  ->constrained('paciente', 'Id_Paciente')
                  ->onDelete('cascade');

            // 🔗 Médico responsable del expediente
            $table->foreignId('Medico_Id')
                  ->constrained('usuario', 'Id_Usuario')
                  ->onDelete('cascade');

            $table->date('Fecha_Apertura')->nullable();
            $table->string('Estado_Expediente', 20)->default('Activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expediente');
    }
};
