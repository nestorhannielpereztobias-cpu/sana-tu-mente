<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

abstract class ModeloBase extends Model
{
    const CREATED_AT = 'creado_en';
    const UPDATED_AT = 'actualizado_en';

    protected $guarded = []; // el panel valida los datos antes de guardar

    // Arma la URL de una imagen. Las del seeder viven en public/images;
    // las subidas desde el panel (con carpeta) viven en storage.
    protected function urlImagen(?string $ruta): string
    {
        if (! $ruta) {
            return 'data:image/svg+xml;utf8,' . rawurlencode(
                '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="200"><rect width="100%" height="100%" fill="#dee2e6"/></svg>'
            );
        }

        return str_contains($ruta, '/') ? asset('storage/' . $ruta) : asset('images/' . $ruta);
    }
}