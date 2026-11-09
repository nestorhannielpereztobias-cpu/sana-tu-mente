@extends('admin.layouts.admin')
@section('title', $item ? 'Editar artículo' : 'Nuevo artículo')

@section('content')
  <h1 class="h3 fw-bold mb-4">{{ $item ? 'Editar artículo' : 'Nuevo artículo' }}</h1>

  <form method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm p-4"
        action="{{ $item ? route('admin.posts.update', $item['id']) : route('admin.posts.store') }}">
    @csrf
    @if($item) @method('PUT') @endif

    <div class="row g-3">
      <div class="col-md-8">
        <label class="form-label">Título</label>
        <input type="text" name="title" class="form-control" value="{{ old('title', data_get($item, 'title')) }}" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Estado</label>
        <select name="status" class="form-select">
          <option value="draft" {{ old('status', data_get($item, 'status')) === 'draft' ? 'selected' : '' }}>Borrador</option>
          <option value="published" {{ old('status', data_get($item, 'status', 'published')) === 'published' ? 'selected' : '' }}>Publicado</option>
        </select>
      </div>

      <div class="col-12">
        <label class="form-label">Imagen</label>
        <input type="file" name="image" accept="image/*" class="form-control" data-preview="#preview">
        <img id="preview" src="{{ data_get($item, 'image') ? asset('images/'.$item['image']) : '' }}"
             class="img-fluid rounded mt-3 shadow-sm {{ data_get($item, 'image') ? '' : 'd-none' }}" style="max-height:220px" alt="">
      </div>

      <div class="col-12">
        <label class="form-label">Contenido</label>
        <textarea name="content" rows="12" class="form-control" required>{{ old('content', data_get($item, 'content')) }}</textarea>
      </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
      <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar</button>
    </div>
  </form>
@endsection