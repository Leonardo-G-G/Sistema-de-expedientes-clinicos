<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nota_medica', function (Blueprint $table) {
            $table->id('Id_Nota');
            $table->foreignId('Expediente_Id')->constrained('expediente', 'Id_Expediente');
            $table->timestamp('Fecha')->useCurrent();
            $table->time('Hora')->nullable();
            $table->text('Diagnostico')->nullable();
            $table->text('Tratamiento')->nullable();
            $table->text('Pronostico')->nullable();
            $table->text('Observacion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nota_medica');
    }
};
