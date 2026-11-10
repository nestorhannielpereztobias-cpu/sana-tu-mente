<?php

namespace App\Models;

class ServicioEspecialista extends ModeloBase
{
    protected $table = 'servicio_especialista';
    protected $casts = ['precio' => 'decimal:2'];
}