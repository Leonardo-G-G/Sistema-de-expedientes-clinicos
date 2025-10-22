<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('antecedentes_patologicos', function (Blueprint $table) {
            $table->id('Id_Antecedente_Patologico');
            $table->foreignId('Historia_Id')->constrained('historia_clinica', 'Id_Historia');
            $table->text('Cirugias')->nullable();
            $table->text('Alergias')->nullable();
            $table->text('Hospitalizaciones')->nullable();
            $table->text('Enfermedades_Infecciosas')->nullable();
            $table->boolean('Transfusiones')->default(false);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antecedentes_patologicos');
    }
};
