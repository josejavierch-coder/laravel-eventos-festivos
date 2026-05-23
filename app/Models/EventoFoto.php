<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EventoFoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'evento_festivo_id',
        'ruta',
    ];

    public function evento()
    {
        return $this->belongsTo(EventoFestivo::class, 'evento_festivo_id');
    }
}
