<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventoFestivo extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'eventos_festivos';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'categoria_id',
        'salon_id',
        'titulo',
        'tematica',
        'cantidad_invitados',
        'dj_set_list',
        'tarta',
        'fecha_evento',
        'slug',
        'descripcion',
        'comentario_cliente',
        'nombre_cliente',
        'foto_cliente',
        'imagen_representativa',
        'video_destacado',
        'estado',
        'vistas',
        'publicado_en',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'estado' => 'boolean',
            'vistas' => 'integer',
            'publicado_en' => 'datetime',
            'fecha_evento' => 'datetime',
            'cantidad_invitados' => 'integer',
        ];
    }

    /**
     * Relación con el salón del evento.
     */
    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class);
    }

    /**
     * Relación con las fotos del evento.
     */
    public function fotos()
    {
        return $this->hasMany(EventoFoto::class, 'evento_festivo_id');
    }

    /**
     * Relación con el usuario que publicó el evento.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relación con la categoría del evento.
     */
    public function categoria(): BelongsTo
    {
        return $this->belongsTo(Categoria::class);
    }
}
