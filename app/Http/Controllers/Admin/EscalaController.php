<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Escala;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EscalaController extends Controller
{
    public function index()
    {
        return view('admin.scales.index', [
            'items' => Escala::with('preguntas.respuestas')->orderBy('nombre')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.scales.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        DB::transaction(fn () => $this->guardar(new Escala(), $request, $datos));

        return redirect()->route('admin.scales.index')->with('ok', 'Escala creada.');
    }

    public function edit(Escala $escala)
    {
        $escala->load('preguntas.respuestas', 'rangos');
        return view('admin.scales.form', ['item' => $escala]);
    }

    public function update(Request $request, Escala $escala)
    {
        $datos = $this->validar($request);
        DB::transaction(fn () => $this->guardar($escala, $request, $datos));

        return redirect()->route('admin.scales.index')->with('ok', 'Escala actualizada.');
    }

    public function destroy(Escala $escala)
    {
        $escala->delete(); // preguntas, respuestas y rangos se borran en cascada

        return redirect()->route('admin.scales.index')->with('ok', 'Escala eliminada.');
    }

    private function validar(Request $request): array
    {
        $d = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'preguntas' => 'required|array|min:1',
            'preguntas.*.texto' => 'required|string|max:255',
            'preguntas.*.respuestas' => 'required|array|size:5',
            'preguntas.*.respuestas.*.texto' => 'required|string|max:100',
            'rangos' => 'required|array|min:1',
            'rangos.*.minimo' => 'required|integer',
            'rangos.*.maximo' => 'required|integer',
            'rangos.*.texto' => 'required|string',
        ]);

        foreach ($d['rangos'] as $r) {
            if ($r['maximo'] < $r['minimo']) {
                throw ValidationException::withMessages([
                    'rangos' => 'En cada rango, "Hasta" debe ser mayor o igual que "Desde".',
                ]);
            }
        }

        return $d;
    }

    private function guardar(Escala $escala, Request $request, array $d): void
    {
        $escala->fill([
            'nombre' => $d['nombre'],
            'descripcion' => $d['descripcion'] ?? null,
            'activa' => $request->boolean('activa'),
        ])->save();

        $escala->preguntas()->delete();
        $escala->rangos()->delete();

        foreach (array_values($d['preguntas']) as $i => $p) {
            $pregunta = $escala->preguntas()->create(['texto' => $p['texto'], 'posicion' => $i + 1]);

            // Los puntos se asignan solos: la primera respuesta vale 1 y la quinta vale 5
            foreach (array_values($p['respuestas']) as $j => $r) {
                $pregunta->respuestas()->create(['texto' => $r['texto'], 'puntos' => $j + 1]);
            }
        }

        foreach (array_values($d['rangos']) as $r) {
            $escala->rangos()->create([
                'minimo' => $r['minimo'], 'maximo' => $r['maximo'], 'texto' => $r['texto'],
            ]);
        }
    }
}