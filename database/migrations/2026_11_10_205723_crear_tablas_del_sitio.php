<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ---------- Especialistas ----------
        Schema::create('especialista', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->string('url_amigable')->unique();
            $t->string('cargo');
            $t->string('area')->nullable();
            $t->string('idiomas')->nullable();
            $t->string('ubicacion')->nullable();
            $t->string('telefono_whatsapp')->nullable();
            $t->text('biografia')->nullable();
            $t->string('foto')->nullable();
            $t->boolean('activo')->default(true);
            $t->unsignedInteger('orden')->default(0);
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        Schema::create('servicio_especialista', function (Blueprint $t) {
            $t->id();
            $t->foreignId('especialista_id')->constrained('especialista')->cascadeOnDelete();
            $t->string('nombre');
            $t->decimal('precio', 10, 2)->nullable();
            $t->unsignedInteger('posicion')->default(0);
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        Schema::create('padecimiento_especialista', function (Blueprint $t) {
            $t->id();
            $t->foreignId('especialista_id')->constrained('especialista')->cascadeOnDelete();
            $t->string('nombre');
            $t->unsignedInteger('posicion')->default(0);
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        Schema::create('formacion_especialista', function (Blueprint $t) {
            $t->id();
            $t->foreignId('especialista_id')->constrained('especialista')->cascadeOnDelete();
            $t->string('titulo');
            $t->string('institucion')->nullable();
            $t->unsignedSmallInteger('anio')->nullable();
            $t->unsignedInteger('posicion')->default(0);
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        // ---------- Blog ----------
        Schema::create('articulo', function (Blueprint $t) {
            $t->id();
            $t->string('titulo');
            $t->string('url_amigable')->unique();
            $t->text('contenido');
            $t->string('imagen')->nullable();
            $t->string('estado')->default('borrador'); // borrador | publicado
            $t->timestamp('publicado_en')->nullable();
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        // ---------- Escalas ----------
        Schema::create('escala', function (Blueprint $t) {
            $t->id();
            $t->string('nombre');
            $t->text('descripcion')->nullable();
            $t->boolean('activa')->default(true);
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        Schema::create('pregunta_escala', function (Blueprint $t) {
            $t->id();
            $t->foreignId('escala_id')->constrained('escala')->cascadeOnDelete();
            $t->string('texto');
            $t->unsignedInteger('posicion')->default(0);
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        Schema::create('respuesta_escala', function (Blueprint $t) {
            $t->id();
            $t->foreignId('pregunta_escala_id')->constrained('pregunta_escala')->cascadeOnDelete();
            $t->string('texto');   // lo que lee el paciente: "Nunca", "A veces"...
            $t->integer('puntos'); // 1 a 5; también define el orden
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });

        Schema::create('rango_escala', function (Blueprint $t) {
            $t->id();
            $t->foreignId('escala_id')->constrained('escala')->cascadeOnDelete();
            $t->integer('minimo');
            $t->integer('maximo');
            $t->text('texto'); // interpretación del resultado
            $t->timestamp('creado_en')->nullable();
            $t->timestamp('actualizado_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rango_escala');
        Schema::dropIfExists('respuesta_escala');
        Schema::dropIfExists('pregunta_escala');
        Schema::dropIfExists('escala');
        Schema::dropIfExists('articulo');
        Schema::dropIfExists('formacion_especialista');
        Schema::dropIfExists('padecimiento_especialista');
        Schema::dropIfExists('servicio_especialista');
        Schema::dropIfExists('especialista');
    }
};