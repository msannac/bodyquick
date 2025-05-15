<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Ejecuta las migraciones.
     */
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('hueco'); // puedes ajustar el tipo de dato según lo que represente "hueco"
            $table->integer('aforo');
            $table->time('hora_inicio');
            $table->integer('duracion'); // en minutos, por ejemplo
            $table->enum('frecuencia', ['una_vez', 'cada_semana', 'cada_mes']);
            $table->foreignId('actividad_id')->constrained('actividades')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Revierte las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
