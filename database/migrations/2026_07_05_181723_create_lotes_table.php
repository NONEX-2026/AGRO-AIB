<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lotes', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('producto');
            $table->string('variedad');
            $table->decimal('cantidad_kg', 12, 2);
            $table->enum('etapa_actual', [
                'Cultivo', 'Recepcion', 'Procesamiento',
                'Empaque', 'Almacenamiento', 'Exportacion'
            ])->default('Cultivo');
            $table->string('proveedor');
            $table->enum('estado', ['En Proceso', 'Completado', 'Anulado'])->default('En Proceso');
            $table->text('observaciones')->nullable();
            $table->foreignId('registrado_por')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lotes');
    }
};