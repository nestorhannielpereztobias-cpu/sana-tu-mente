<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Escala;
use App\Models\Especialista;
use Illuminate\Http\Request;

class PublicoController extends Controller
{
    public function inicio()
    {
        return view('public.home', [
            'especialistas' => Especialista::where('activo', true)->orderBy('orden')->get(),
            'articulos' => Articulo::where('estado', 'publicado')->orderByDesc('publicado_en')->take(6)->get(),
            'escalas' => Escala::where('activa', true)->withCount('preguntas')->orderBy('nombre')->get(),
        ]);
    }

    public function especialista(Especialista $especialista)
    {
        abort_unless($especialista->activo, 404);
        $especialista->load('servicios', 'padecimientos', 'formaciones');

        return view('public.specialists.show', ['especialista' => $especialista]);
    }

    public function articulo(Articulo $articulo)
    {
        abort_unless($articulo->estado === 'publicado', 404);

        return view('public.articles.show', ['articulo' => $articulo]);
    }

    public function escala(Escala $escala)
    {
        abort_unless($escala->activa, 404);
        $escala->load('preguntas.respuestas');

        return view('public.scales.show', ['escala' => $escala]);
    }

    // Calcula el resultado y lo muestra. No se guarda nada en la BD.
    public function resultadoEscala(Request $request, Escala $escala)
    {
        abort_unless($escala->activa, 404);
        $escala->load('preguntas.respuestas', 'rangos');

        $reglas = [];
        foreach ($escala->preguntas as $p) {
            $reglas['respuestas.' . $p->id] = 'required|integer';
        }
        $request->validate($reglas, ['required' => 'Responde todas las preguntas.']);

        $total = 0;
        foreach ($escala->preguntas as $p) {
            // Se busca la respuesta dentro de la pregunta para no confiar en el valor enviado
            $resp = $p->respuestas->firstWhere('id', (int) $request->input('respuestas.' . $p->id));
            abort_if(! $resp, 422);
            $total += $resp->puntos;
        }

        $maximo = $escala->preguntas->sum(fn ($p) => $p->respuestas->max('puntos'));
        $rango = $escala->rangos->first(fn ($r) => $total >= $r->minimo && $total <= $r->maximo);

        return view('public.scales.resultado', compact('escala', 'total', 'maximo', 'rango'));
    }
}