<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nota_medica', function (Blueprint $table) {
            $table->id('Id_Nota');
            $table->foreignId('Historia_Id')->constrained('historia_clinica', 'Id_Historia');
            $table->date('Fecha')->useCurrent();
            $table->time('Hora')->nullable();
            $table->float('Peso')->nullable();
            $table->float('Talla')->nullable();
            $table->string('Presion_Arterial', 20)->nullable();
            $table->integer('Frecuencia_Cardiaca')->nullable();
            $table->text('Exploracion_Fisica')->nullable();
            $table->text('Diagnostico')->nullable();
            $table->text('Tratamiento')->nullable();
            $table->text('Plan_A_Seguir')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_medica');
    }
};
