<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('antecedentes_ginecoobstetricos', function (Blueprint $table) {
            $table->id('Id_Antecedente_Gineco');
            $table->foreignId('Historia_Id')->constrained('historia_clinica', 'Id_Historia')->onDelete('cascade');

            $table->integer('Menarca_Edad')->nullable()->comment('Edad en la que comenzó la menstruación');
            $table->string('Tipo_Ciclo', 100)->nullable()->comment('Ej. 28x4, 30x3');
            $table->enum('Ciclos_Regulares', ['Sí', 'No'])->nullable();
            $table->enum('Ciclos_Dolor', ['Sí', 'No'])->nullable();
            $table->date('Ultima_Regla')->nullable();
            $table->integer('Inicio_Vida_Sexual')->nullable()->comment('Edad de inicio de vida sexual');
            $table->integer('Gestaciones')->default(0);
            $table->integer('Partos')->default(0);
            $table->integer('Abortos')->default(0);
            $table->integer('Cesareas')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('antecedentes_ginecoobstetricos');
    }
};
