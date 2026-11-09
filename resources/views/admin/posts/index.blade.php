@extends('admin.layouts.admin')
@section('title', 'Blog')

@section('content')
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 fw-bold mb-0">Artículos del blog</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Nuevo artículo</a>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr><th>Imagen</th><th>Título</th><th>Fecha</th><th>Estado</th><th class="text-end">Acciones</th></tr>
        </thead>
        <tbody>
          @forelse($items as $p)
            <tr>
              <td><img src="{{ $p['image'] ? asset('images/'.$p['image']) : 'https://via.placeholder.com/48' }}" class="rounded thumb" alt=""></td>
              <td class="fw-semibold">{{ $p['title'] }}</td>
              <td>{{ $p['date'] }}</td>
              <td><span class="badge {{ $p['status'] === 'published' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $p['status'] === 'published' ? 'Publicado' : 'Borrador' }}</span></td>
              <td class="text-end">
                <a href="{{ route('admin.posts.edit', $p['id']) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('admin.posts.destroy', $p['id']) }}" method="POST" class="d-inline js-delete">
                  @csrf @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
          @empty
            <tr><td colspan="5" class="text-center text-muted py-4">Aún no hay artículos.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
@endsection