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
          <tr><th>Foto</th><th>Nombre</th><th>Especialidad</th><th>Estado</th><th class="text-end">Acciones</th></tr>
        </thead>
        <tbody>
          @forelse($items as $s)
            <tr>
              <td><img src="{{ asset('images/'.$s['photo']) }}" class="rounded-circle thumb" alt="" onerror="this.src='https://via.placeholder.com/48'"></td>
              <td class="fw-semibold">{{ $s['name'] }}<br><small class="text-muted fw-normal">{{ $s['title'] }}</small></td>
              <td>{{ $s['area'] }}</td>
              <td>
                <span class="badge {{ $s['active'] ? 'bg-success' : 'bg-secondary' }}">{{ $s['active'] ? 'Visible' : 'Oculto' }}</span>
              </td>
              <td class="text-end">
                <a href="{{ route('admin.specialists.edit', $s['id']) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.specialists.destroy', $s['id']) }}" method="POST" class="d-inline js-delete">
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