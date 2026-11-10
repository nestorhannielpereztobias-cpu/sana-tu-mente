<?php

namespace App\Models;

class Escala extends ModeloBase
{
    protected $table = 'escala';
    protected $casts = ['activa' => 'boolean'];

    public function preguntas()
    {
        return $this->hasMany(PreguntaEscala::class, 'escala_id')->orderBy('posicion');
    }

    public function rangos()
    {
        return $this->hasMany(RangoEscala::class, 'escala_id')->orderBy('minimo');
    }
}