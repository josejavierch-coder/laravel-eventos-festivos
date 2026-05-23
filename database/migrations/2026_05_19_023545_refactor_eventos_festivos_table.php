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
        Schema::table('eventos_festivos', function (Blueprint $table) {
            $table->foreignId('salon_id')->nullable()->after('categoria_id')->constrained('salons')->nullOnDelete();
            $table->timestamp('fecha_evento')->nullable()->after('titulo');
            $table->renameColumn('imagen_portada', 'imagen_representativa');
            $table->dropColumn(['tipo', 'archivo', 'enlace_externo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos_festivos', function (Blueprint $table) {
            $table->dropForeign(['salon_id']);
            $table->dropColumn(['salon_id', 'fecha_evento']);
            $table->renameColumn('imagen_representativa', 'imagen_portada');
            $table->enum('tipo', ['imagen', 'pdf', 'enlace', 'archivo'])->after('descripcion');
            $table->string('archivo')->nullable()->after('tipo');
            $table->string('enlace_externo')->nullable()->after('archivo');
        });
    }
};
