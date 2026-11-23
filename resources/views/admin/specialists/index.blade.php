@extends('admin.layouts.admin')
@section('title', 'Especialistas')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">Especialistas</h1>
    <a href="{{ route('admin.specialists.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuevo especialista</a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr><th>Foto</th><th>Nombre</th><th>Área</th><th>Estado</th><th class="text-end">Acciones</th></tr>
        </thead>
        <tbody>
          @forelse($items as $e)
            <tr>
              <td><img src="{{ $e->foto_url }}" class="rounded-circle thumb" alt=""></td>
              <td class="fw-semibold">{{ $e->nombre }}<br><small class="text-muted fw-normal">{{ $e->cargo }}</small></td>
              <td>{{ $e->area }}</td>
              <td><span class="badge {{ $e->activo ? 'bg-success' : 'bg-secondary' }}">{{ $e->activo ? 'Visible' : 'Oculto' }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.specialists.edit', $e) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.specialists.destroy', $e) }}" method="POST" class="d-inline js-delete">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Aún no hay especialistas.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection