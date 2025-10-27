<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('historia_clinica', function (Blueprint $table) {
            $table->id('Id_Historia');
            $table->foreignId('Expediente_Id')->constrained('expediente', 'Id_Expediente');
            $table->text('Padecimiento_Actual')->nullable();
            $table->text('Exploracion_Fisica')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('historia_clinica');
    }
};
