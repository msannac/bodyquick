<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('fecha');
            $table->time('hora');
            $table->enum('tipo_sesion', [
                'entrenamiento convencional',
                'entrenamiento con chaleco de electroestimulacion',
                'readaptacion de lesiones'
            ]);
            $table->string('estado')->default('pendiente'); // Puede ser "pendiente", "confirmada", "cancelada"
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};