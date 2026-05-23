<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('eventos_festivos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('categoria_id')->nullable()->constrained()->nullOnDelete();
            $table->string('titulo');
            $table->string('slug')->unique();
            $table->longText('descripcion')->nullable();
            $table->enum('tipo', ['imagen', 'pdf', 'enlace', 'archivo']);
            $table->string('archivo')->nullable();
            $table->string('enlace_externo')->nullable();
            $table->string('imagen_portada')->nullable();
            $table->boolean('estado')->default(true);
            $table->unsignedBigInteger('vistas')->default(0);
            $table->timestamp('publicado_en')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eventos_festivos');
    }
};
