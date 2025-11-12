<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('antecedentes_no_patologicos', function (Blueprint $table) {
            $table->id('Id_Antecedente_NoPatologico');
            $table->foreignId('Historia_Id')->constrained('historia_clinica', 'Id_Historia');
            $table->string('Tipo_Vivienda', 100)->nullable();
            $table->string('Religion', 100)->nullable();
            $table->string('Alimentacion', 200)->nullable();
            $table->string('Actividad_Fisica', 200)->nullable();
            $table->boolean('Tabaquismo')->default(false);
            $table->boolean('Alcoholismo')->default(false);
            $table->boolean('Drogas')->default(false);
            $table->string('Tipo_Sangre', 10)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antecedentes_no_patologicos');
    }
};
