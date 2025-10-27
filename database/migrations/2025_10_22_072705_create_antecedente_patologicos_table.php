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
            $table->text('Descripcion')->nullable(); // Texto libre
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antecedentes_patologicos');
    }
};
