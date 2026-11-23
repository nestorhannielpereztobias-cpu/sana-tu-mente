<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Especialista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EspecialistaController extends Controller
{
    public function index()
    {
        return view('admin.specialists.index', [
            'items' => Especialista::orderBy('orden')->orderBy('nombre')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.specialists.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);

        DB::transaction(function () use ($request, $datos) {
            $esp = new Especialista($this->campos($request, $datos));
            $esp->url_amigable = $this->urlUnica($datos['nombre']);
            $esp->orden = (Especialista::max('orden') ?? 0) + 1;
            $esp->save();
            $this->guardarListas($esp, $datos);
        });

        return redirect()->route('admin.specialists.index')->with('ok', 'Especialista creado.');
    }

    public function edit(Especialista $especialista)
    {
        $especialista->load('servicios', 'padecimientos', 'formaciones');
        return view('admin.specialists.form', ['item' => $especialista]);
    }

    public function update(Request $request, Especialista $especialista)
    {
        $datos = $this->validar($request);

        DB::transaction(function () use ($request, $datos, $especialista) {
            $especialista->update($this->campos($request, $datos, $especialista));
            $this->guardarListas($especialista, $datos);
        });

        return redirect()->route('admin.specialists.index')->with('ok', 'Especialista actualizado.');
    }

    public function destroy(Especialista $especialista)
    {
        $this->borrarFoto($especialista);
        $especialista->delete(); // las listas se borran en cascada

        return redirect()->route('admin.specialists.index')->with('ok', 'Especialista eliminado.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'nombre' => 'required|string|max:255',
            'cargo' => 'required|string|max:255',
            'area' => 'nullable|string|max:255',
            'idiomas' => 'nullable|string|max:255',
            'ubicacion' => 'nullable|string|max:255',
            'telefono_whatsapp' => 'nullable|string|max:20',
            'biografia' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'servicios.*.nombre' => 'required|string|max:255',
            'servicios.*.precio' => 'nullable|numeric|min:0',
            'padecimientos.*.nombre' => 'required|string|max:255',
            'formaciones.*.titulo' => 'required|string|max:255',
            'formaciones.*.institucion' => 'nullable|string|max:255',
            'formaciones.*.anio' => 'nullable|integer|min:1950|max:2100',
        ]);
    }

    private function campos(Request $request, array $d, ?Especialista $actual = null): array
    {
        $campos = [
            'nombre' => $d['nombre'],
            'cargo' => $d['cargo'],
            'area' => $d['area'] ?? null,
            'idiomas' => $d['idiomas'] ?? null,
            'ubicacion' => $d['ubicacion'] ?? null,
            'telefono_whatsapp' => preg_replace('/\D/', '', $d['telefono_whatsapp'] ?? '') ?: null,
            'biografia' => $d['biografia'] ?? null,
            'activo' => $request->boolean('activo'),
        ];

        if ($request->hasFile('foto')) {
            $this->borrarFoto($actual);
            $campos['foto'] = $request->file('foto')->store('especialistas', 'public');
        }

        return $campos;
    }

    private function guardarListas(Especialista $esp, array $d): void
    {
        $esp->servicios()->delete();
        $esp->padecimientos()->delete();
        $esp->formaciones()->delete();

        foreach (array_values($d['servicios'] ?? []) as $i => $s) {
            $esp->servicios()->create([
                'nombre' => $s['nombre'],
                'precio' => $s['precio'] ?? null,
                'posicion' => $i + 1,
            ]);
        }
        foreach (array_values($d['padecimientos'] ?? []) as $i => $p) {
            $esp->padecimientos()->create(['nombre' => $p['nombre'], 'posicion' => $i + 1]);
        }
        foreach (array_values($d['formaciones'] ?? []) as $i => $f) {
            $esp->formaciones()->create([
                'titulo' => $f['titulo'],
                'institucion' => $f['institucion'] ?? null,
                'anio' => $f['anio'] ?? null,
                'posicion' => $i + 1,
            ]);
        }
    }

    private function urlUnica(string $nombre): string
    {
        $base = Str::slug($nombre);
        $url = $base;
        $n = 2;
        while (Especialista::where('url_amigable', $url)->exists()) {
            $url = $base . '-' . $n++;
        }
        return $url;
    }

    private function borrarFoto(?Especialista $esp): void
    {
        // Solo se borran las fotos subidas desde el panel (las de public/images no)
        if ($esp && $esp->foto && str_contains($esp->foto, '/')) {
            Storage::disk('public')->delete($esp->foto);
        }
    }
}