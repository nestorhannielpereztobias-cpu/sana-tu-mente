<?php

namespace App\Models;

class RespuestaEscala extends ModeloBase
{
    protected $table = 'respuesta_escala';

    public function pregunta()
    {
        return $this->belongsTo(PreguntaEscala::class, 'pregunta_escala_id');
    }
}