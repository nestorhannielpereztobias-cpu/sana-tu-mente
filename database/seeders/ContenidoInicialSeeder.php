<?php

namespace Database\Seeders;

use App\Models\Articulo;
use App\Models\Escala;
use App\Models\Especialista;
use Illuminate\Database\Seeder;

class ContenidoInicialSeeder extends Seeder
{
    public function run(): void
    {
        // ---------- Dra. Diana Pérez ----------
        $diana = Especialista::create([
            'nombre' => 'Dra. Diana Pérez',
            'url_amigable' => 'diana-perez',
            'cargo' => 'Médico Psiquiatra',
            'area' => 'Psiquiatría Perinatal',
            'idiomas' => 'Español, Inglés',
            'ubicacion' => 'Guanajuato, México | Atención Presencial y Online',
            'telefono_whatsapp' => '5214611578082',
            'biografia' => 'Soy médico especialista en psiquiatría sumamente interesada en la psiquiatría perinatal, porque considero que cuidar la salud mental de las mujeres en esta etapa es vital para hacer vínculos sanos y crianzas positivas.',
            'foto' => 'doctoraDianaPerez.webp',
            'orden' => 1,
        ]);

        foreach ([
            ['Consulta psiquiátrica', 1200],
            ['Psiquiatría perinatal', 1500],
            ['Seguimiento farmacológico', 800],
        ] as $i => [$nombre, $precio]) {
            $diana->servicios()->create(['nombre' => $nombre, 'precio' => $precio, 'posicion' => $i + 1]);
        }

        foreach (['Depresión posparto', 'Ansiedad', 'Trastornos del estado de ánimo'] as $i => $nombre) {
            $diana->padecimientos()->create(['nombre' => $nombre, 'posicion' => $i + 1]);
        }

        foreach ([
            ['Médico Cirujano', 'Universidad (ejemplo)', 2012],
            ['Especialidad en Psiquiatría', 'Hospital (ejemplo)', 2018],
            ['Certificación en Psiquiatría Perinatal', 'Consejo (ejemplo)', 2020],
        ] as $i => [$titulo, $institucion, $anio]) {
            $diana->formaciones()->create([
                'titulo' => $titulo, 'institucion' => $institucion, 'anio' => $anio, 'posicion' => $i + 1,
            ]);
        }

        // ---------- Dr. Andrés Barrera ----------
        Especialista::create([
            'nombre' => 'Dr. Andrés Barrera',
            'url_amigable' => 'andres-barrera',
            'cargo' => 'Doctor Sueño',
            'area' => 'Medicina del Sueño',
            'idiomas' => 'Español',
            'ubicacion' => 'Celaya, Guanajuato',
            'telefono_whatsapp' => '5214611578082',
            'foto' => 'doctorAndresBarrera.jpg',
            'orden' => 2,
        ]);

        // ---------- Blog ----------
        Articulo::create([
            'titulo' => 'Guía básica de Mindfulness',
            'url_amigable' => 'guia-basica-de-mindfulness',
            'contenido' => 'Técnicas sencillas para reducir el estrés en tu rutina diaria.',
            'estado' => 'publicado',
            'publicado_en' => now(),
        ]);

        // ---------- Escala de ejemplo ----------
        $escala = Escala::create([
            'nombre' => 'Escala de ejemplo',
            'descripcion' => 'Tamizaje breve de ejemplo.',
        ]);

        $textos = ['Nunca', 'Pocas veces', 'A veces', 'Casi siempre', 'Siempre'];

        foreach (['Me he sentido nervioso o ansioso', 'Me ha costado trabajo relajarme'] as $i => $texto) {
            $pregunta = $escala->preguntas()->create(['texto' => $texto, 'posicion' => $i + 1]);
            foreach ($textos as $j => $t) {
                $pregunta->respuestas()->create(['texto' => $t, 'puntos' => $j + 1]);
            }
        }

        $escala->rangos()->create(['minimo' => 2, 'maximo' => 5, 'texto' => 'Nivel bajo']);
        $escala->rangos()->create(['minimo' => 6, 'maximo' => 10, 'texto' => 'Nivel alto, consulta a un especialista']);
    }
}