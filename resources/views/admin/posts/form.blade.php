@extends('admin.layouts.admin')
@section('title', $item ? 'Editar artículo' : 'Nuevo artículo')

@section('content')
  <h1 class="h3 fw-bold mb-4">{{ $item ? 'Editar artículo' : 'Nuevo artículo' }}</h1>

  <form method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm p-4"
        action="{{ $item ? route('admin.posts.update', $item) : route('admin.posts.store') }}">
    @csrf
    @if($item) @method('PUT') @endif

    <div class="row g-3">
      <div class="col-md-8">
        <label class="form-label">Título</label>
        <input type="text" name="titulo" class="form-control" value="{{ old('titulo', $item?->titulo) }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Estado</label>
        @php $estado = old('estado', $item?->estado ?? 'publicado'); @endphp
        <select name="estado" class="form-select">
          <option value="borrador" {{ $estado === 'borrador' ? 'selected' : '' }}>Borrador</option>
          <option value="publicado" {{ $estado === 'publicado' ? 'selected' : '' }}>Publicado</option>
        </select>
      </div>

      <div class="col-12">
        <label class="form-label">Imagen</label>
        <input type="file" name="imagen" accept="image/*" class="form-control" data-preview="#preview">
        <div class="form-text">Máximo 3 MB.</div>
        <img id="preview" src="{{ $item?->imagen ? $item->imagen_url : '' }}"
             class="img-fluid rounded mt-3 shadow-sm {{ $item?->imagen ? '' : 'd-none' }}" style="max-height:220px" alt="">
      </div>

      <div class="col-12">
        <label class="form-label">Contenido</label>
        <textarea name="contenido" rows="12" class="form-control" required>{{ old('contenido', $item?->contenido) }}</textarea>
      </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
      <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar</button>
    </div>
  </form>
@endsection