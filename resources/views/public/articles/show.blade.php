@extends('layouts.app')

@section('title', $articulo->titulo)

@section('content')
  <main class="container" style="padding-top: 110px; padding-bottom: 60px; max-width: 800px;">
    <a href="{{ url('/#blog') }}" class="btn btn-outline-primary btn-sm mb-4">
      <i class="bi bi-arrow-left me-1"></i> Volver al blog
    </a>

    <article class="card border-0 shadow-sm overflow-hidden">
      @if($articulo->imagen)
        <img src="{{ $articulo->imagen_url }}" class="w-100" style="max-height:360px;object-fit:cover" alt="{{ $articulo->titulo }}">
      @endif
      <div class="card-body p-4 p-md-5">
        <h1 class="h2 fw-bold mb-2">{{ $articulo->titulo }}</h1>
        <p class="text-muted small mb-4">
          <i class="bi bi-calendar3 me-1"></i>{{ $articulo->publicado_en?->format('d/m/Y') }}
        </p>
        <div style="white-space: pre-line; line-height: 1.8;">{{ $articulo->contenido }}</div>
      </div>
    </article>
  </main>
@endsection