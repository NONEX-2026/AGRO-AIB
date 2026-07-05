<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('rol', [
                'Administrador',
                'Supervisor',
                'Operario agrícola',
                'Operario de planta',
                'Empaquetador',
                'Transporte'
            ])->default('Operario agrícola');
            $table->enum('estado', ['Activo', 'Inactivo'])->default('Activo');
            $table->timestamp('ultimo_acceso')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
