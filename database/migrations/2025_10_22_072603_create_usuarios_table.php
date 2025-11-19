<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('Id_Usuario');
            $table->string('Nombre', 100);
            $table->string('Apellido', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('Cedula_Profesional', 50)->nullable();
            $table->string('Especialidad', 100)->nullable();
            $table->timestamp('Fecha_Registro')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
