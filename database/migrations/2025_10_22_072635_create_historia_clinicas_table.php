<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historia_clinica', function (Blueprint $table) {
            $table->id('Id_Historia');

            // 🔗 Un expediente solo puede tener una historia clínica
            $table->foreignId('Expediente_Id')
                  ->unique()
                  ->constrained('expediente', 'Id_Expediente')
                  ->onDelete('cascade');

            $table->text('Padecimiento_Actual')->nullable();
            $table->text('Exploracion_Fisica')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historia_clinica');
    }
};
