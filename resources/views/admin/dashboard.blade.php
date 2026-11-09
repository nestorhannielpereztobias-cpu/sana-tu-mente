@extends('admin.layouts.admin')
@section('title', 'Inicio')

@section('content')
  <h1 class="h3 fw-bold mb-4">Bienvenido</h1>
  <div class="row g-4">
    @foreach([
      ['specialists', 'Especialistas', 'bi-people-fill'],
      ['posts', 'Artículos del blog', 'bi-journal-text'],
      ['scales', 'Escalas', 'bi-clipboard2-check-fill'],
    ] as [$key, $label, $icon])
      <div class="col-md-4">
        <a href="{{ route("admin.$key.index") }}" class="text-decoration-none">
          <div class="card border-0 shadow-sm p-4 text-center h-100">
            <i class="bi {{ $icon }} text-primary display-5"></i>
            <div class="display-6 fw-bold text-dark mt-2">{{ $counts[$key] }}</div>
            <div class="text-muted">{{ $label }}</div>
          </div>
        </a>
      </div>
    @endforeach
  </div>
@endsection