@extends('admin.layouts.admin')
@section('title', $item ? 'Editar especialista' : 'Nuevo especialista')

@section('content')
  <h1 class="h3 fw-bold mb-4">{{ $item ? 'Editar especialista' : 'Nuevo especialista' }}</h1>

  <form method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm p-4"
        action="{{ $item ? route('admin.specialists.update', $item['id']) : route('admin.specialists.store') }}">
    @csrf
    @if($item) @method('PUT') @endif

    <div class="row g-4">
      <div class="col-md-4 text-center">
        <img id="preview" src="{{ $item ? asset('images/'.$item['photo']) : '' }}"
             class="rounded-circle mb-3 shadow-sm {{ $item ? '' : 'd-none' }}" width="150" height="150" style="object-fit:cover" alt=""
             onerror="this.src='https://via.placeholder.com/150'">
        <label class="form-label d-block">Foto</label>
        <input type="file" name="photo" accept="image/*" class="form-control" data-preview="#preview">
      </div>

      <div class="col-md-8">
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', data_get($item, 'name')) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Título / cargo</label>
            <input type="text" name="title" class="form-control" placeholder="Médico Psiquiatra" value="{{ old('title', data_get($item, 'title')) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Área de enfoque</label>
            <input type="text" name="area" class="form-control" placeholder="Psiquiatría Perinatal" value="{{ old('area', data_get($item, 'area')) }}">
          </div>
          <div class="col-md-8">
            <label class="form-label">Ubicación / modalidad</label>
            <input type="text" name="location" class="form-control" value="{{ old('location', data_get($item, 'location')) }}">
          </div>
          <div class="col-md-4">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="phone" class="form-control" placeholder="5214611234567" value="{{ old('phone', data_get($item, 'phone')) }}">
          </div>
          <div class="col-12">
            <label class="form-label">Acerca de mí</label>
            <textarea name="bio" rows="6" class="form-control">{{ old('bio', data_get($item, 'bio')) }}</textarea>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ old('active', data_get($item, 'active', true)) ? 'checked' : '' }}>
              <label class="form-check-label" for="active">Visible en la página pública</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-4">
      <a href="{{ route('admin.specialists.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar</button>
    </div>
  </form>
@endsection