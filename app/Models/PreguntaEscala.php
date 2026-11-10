<?php

namespace App\Models;

class PreguntaEscala extends ModeloBase
{
    protected $table = 'pregunta_escala';

    public function escala()
    {
        return $this->belongsTo(Escala::class, 'escala_id');
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestaEscala::class, 'pregunta_escala_id')->orderBy('puntos');
    }
}