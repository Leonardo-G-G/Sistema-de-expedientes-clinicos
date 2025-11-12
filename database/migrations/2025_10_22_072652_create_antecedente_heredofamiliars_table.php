<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('antecedentes_heredofamiliares', function (Blueprint $table) {
            $table->id('Id_Antecedente_Heredo');
            $table->foreignId('Historia_Id')->constrained('historia_clinica', 'Id_Historia');
            $table->boolean('Diabetes')->default(false);
            $table->boolean('Hipertension')->default(false);
            $table->boolean('Cancer')->default(false);
            $table->text('Descripcion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antecedentes_heredofamiliares');
    }
};
