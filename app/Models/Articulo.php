<?php

namespace App\Models;

class Articulo extends ModeloBase
{
    protected $table = 'articulo';
    protected $casts = ['publicado_en' => 'datetime'];

    public function getImagenUrlAttribute(): string
    {
        return $this->urlImagen($this->imagen);
    }
}