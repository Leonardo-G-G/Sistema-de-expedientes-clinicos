<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rol_usuario', function (Blueprint $table) {
            $table->id('Id_Rol');
            $table->string('Nombre', 50);
            $table->text('Descripcion')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rol_usuario');
    }
};
