@extends('admin.layouts.admin')
@section('title', 'Escalas')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">Escalas</h1>
    <a href="{{ route('admin.scales.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nueva escala</a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr><th>Nombre</th><th>Preguntas</th><th>Puntaje máx.</th><th>Estado</th><th class="text-end">Acciones</th></tr>
        </thead>
        <tbody>
          @forelse($items as $e)
            <tr>
              <td class="fw-semibold">{{ $e->nombre }}<br><small class="text-muted fw-normal">{{ $e->descripcion }}</small></td>
              <td>{{ $e->preguntas->count() }}</td>
              <td>{{ $e->preguntas->sum(fn ($p) => $p->respuestas->max('puntos')) }}</td>
              <td><span class="badge {{ $e->activa ? 'bg-success' : 'bg-secondary' }}">{{ $e->activa ? 'Activa' : 'Oculta' }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.scales.edit', $e) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.scales.destroy', $e) }}" method="POST" class="d-inline js-delete">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Aún no hay escalas.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection