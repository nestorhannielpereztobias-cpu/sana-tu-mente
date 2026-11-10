<?php

namespace App\Models;

class Especialista extends ModeloBase
{
    protected $table = 'especialista';
    protected $casts = ['activo' => 'boolean'];

    public function servicios()
    {
        return $this->hasMany(ServicioEspecialista::class, 'especialista_id')->orderBy('posicion');
    }

    public function padecimientos()
    {
        return $this->hasMany(PadecimientoEspecialista::class, 'especialista_id')->orderBy('posicion');
    }

    public function formaciones()
    {
        return $this->hasMany(FormacionEspecialista::class, 'especialista_id')->orderBy('posicion');
    }

    public function getFotoUrlAttribute(): string
    {
        return $this->urlImagen($this->foto);
    }
}