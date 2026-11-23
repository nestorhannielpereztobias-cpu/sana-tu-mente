@extends('layouts.app')

@section('title', $escala->nombre)

@section('content')
  <main class="container" style="padding-top: 110px; padding-bottom: 60px; max-width: 800px;">
    <a href="{{ url('/#escalas') }}" class="btn btn-outline-primary btn-sm mb-4">
      <i class="bi bi-arrow-left me-1"></i> Volver
    </a>

    <h1 class="h2 fw-bold mb-2">{{ $escala->nombre }}</h1>
    @if($escala->descripcion)<p class="text-muted mb-4">{{ $escala->descripcion }}</p>@endif

    @if($errors->any())
      <div class="alert alert-warning">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('escalas.resultado', $escala) }}">
      @csrf
      @foreach($escala->preguntas as $i => $p)
        <div class="card border-0 shadow-sm p-4 mb-3">
          <p class="fw-semibold mb-3">{{ $i + 1 }}. {{ $p->texto }}</p>
          <div class="d-flex flex-wrap gap-2">
            @foreach($p->respuestas as $r)
              <input type="radio" class="btn-check" name="respuestas[{{ $p->id }}]" id="r{{ $r->id }}"
                     value="{{ $r->id }}" {{ (int) old('respuestas.' . $p->id) === $r->id ? 'checked' : '' }} required>
              <label class="btn btn-outline-primary btn-sm" for="r{{ $r->id }}">{{ $r->texto }}</label>
            @endforeach
          </div>
        </div>
      @endforeach

      <div class="text-end">
        <button class="btn btn-primary px-4">Ver mi resultado</button>
      </div>
    </form>
  </main>
@endsection