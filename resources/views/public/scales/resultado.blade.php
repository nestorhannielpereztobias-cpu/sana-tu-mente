@extends('layouts.app')

@section('title', 'Resultado - ' . $escala->nombre)

@section('content')
  <main class="container" style="padding-top: 110px; padding-bottom: 60px; max-width: 700px;">
    <div class="card border-0 shadow-sm p-4 p-md-5 text-center">
      <i class="bi bi-clipboard2-pulse text-primary display-4"></i>
      <h1 class="h3 fw-bold mt-2">{{ $escala->nombre }}</h1>

      <div class="display-4 fw-bold text-primary my-3">{{ $total }} <small class="fs-5 text-muted">/ {{ $maximo }}</small></div>

      @if($rango)
        <div class="alert alert-primary">{{ $rango->texto }}</div>
      @else
        <div class="alert alert-secondary">No hay una interpretación configurada para este puntaje.</div>
      @endif

      <p class="text-muted small">
        Este resultado es orientativo y no sustituye una valoración profesional. Tus respuestas no se guardan.
      </p>

      <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
        <a href="{{ route('escalas.show', $escala) }}" class="btn btn-outline-primary">Repetir</a>
        <a href="{{ url('/#especialistas') }}" class="btn btn-primary">Agendar con un especialista</a>
      </div>
    </div>
  </main>
@endsection