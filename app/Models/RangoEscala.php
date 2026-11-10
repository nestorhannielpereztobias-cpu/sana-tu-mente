<?php

namespace App\Models;

class RangoEscala extends ModeloBase
{
    protected $table = 'rango_escala';

    public function escala()
    {
        return $this->belongsTo(Escala::class, 'escala_id');
    }
}