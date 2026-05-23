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
            $table->string('tematica')->nullable()->after('titulo');
            $table->integer('cantidad_invitados')->nullable()->after('tematica');
            $table->string('dj_set_list')->nullable()->after('cantidad_invitados');
            $table->string('tarta')->nullable()->after('dj_set_list');
            $table->text('comentario_cliente')->nullable()->after('descripcion');
            $table->string('nombre_cliente')->nullable()->after('comentario_cliente');
            $table->string('foto_cliente')->nullable()->after('nombre_cliente');
            $table->string('video_destacado')->nullable()->after('imagen_representativa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eventos_festivos', function (Blueprint $table) {
            $table->dropColumn([
                'tematica',
                'cantidad_invitados',
                'dj_set_list',
                'tarta',
                'comentario_cliente',
                'nombre_cliente',
                'foto_cliente',
                'video_destacado'
            ]);
        });
    }
};
