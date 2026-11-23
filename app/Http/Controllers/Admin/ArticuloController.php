<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticuloController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', ['items' => Articulo::orderByDesc('creado_en')->get()]);
    }

    public function create()
    {
        return view('admin.posts.form', ['item' => null]);
    }

    public function store(Request $request)
    {
        $datos = $this->validar($request);
        $articulo = new Articulo();
        $this->llenar($articulo, $request, $datos);
        $articulo->url_amigable = $this->urlUnica($datos['titulo']);
        $articulo->save();

        return redirect()->route('admin.posts.index')->with('ok', 'Artículo creado.');
    }

    public function edit(Articulo $articulo)
    {
        return view('admin.posts.form', ['item' => $articulo]);
    }

    public function update(Request $request, Articulo $articulo)
    {
        $datos = $this->validar($request);
        $this->llenar($articulo, $request, $datos);
        $articulo->save();

        return redirect()->route('admin.posts.index')->with('ok', 'Artículo actualizado.');
    }

    public function destroy(Articulo $articulo)
    {
        $this->borrarImagen($articulo);
        $articulo->delete();

        return redirect()->route('admin.posts.index')->with('ok', 'Artículo eliminado.');
    }

    private function validar(Request $request): array
    {
        return $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'estado' => 'required|in:borrador,publicado',
            'imagen' => 'nullable|image|max:3072',
        ]);
    }

    private function llenar(Articulo $articulo, Request $request, array $d): void
    {
        $articulo->titulo = $d['titulo'];
        $articulo->contenido = $d['contenido'];
        $articulo->estado = $d['estado'];

        if ($d['estado'] === 'publicado' && ! $articulo->publicado_en) {
            $articulo->publicado_en = now();
        }

        if ($request->hasFile('imagen')) {
            $this->borrarImagen($articulo);
            $articulo->imagen = $request->file('imagen')->store('articulos', 'public');
        }
    }

    private function urlUnica(string $titulo): string
    {
        $base = Str::slug($titulo);
        $url = $base;
        $n = 2;
        while (Articulo::where('url_amigable', $url)->exists()) {
            $url = $base . '-' . $n++;
        }
        return $url;
    }

    private function borrarImagen(Articulo $articulo): void
    {
        if ($articulo->imagen && str_contains($articulo->imagen, '/')) {
            Storage::disk('public')->delete($articulo->imagen);
        }
    }
}