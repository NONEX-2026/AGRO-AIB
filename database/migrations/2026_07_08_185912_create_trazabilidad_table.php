<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trazabilidad', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lote_id')->constrained('lotes')->cascadeOnDelete();
            $table->enum('etapa', [
                'Cultivo',
                'Recepcion',
                'Procesamiento',
                'Empaque',
                'Almacenamiento',
                'Exportacion'
            ]);
            $table->date('fecha');
            $table->text('observaciones');
            $table->foreignId('responsable_id')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trazabilidad');
    }
};
