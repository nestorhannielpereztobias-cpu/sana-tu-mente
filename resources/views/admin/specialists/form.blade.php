@extends('admin.layouts.admin')
@section('title', $item ? 'Editar especialista' : 'Nuevo especialista')

@php
  $activo = old() ? (bool) old('activo') : ($item->activo ?? true);
  $ini = [
    'servicios' => old('servicios', $item ? $item->servicios->map(fn ($s) => ['nombre' => $s->nombre, 'precio' => $s->precio])->values() : []),
    'padecimientos' => old('padecimientos', $item ? $item->padecimientos->map(fn ($p) => ['nombre' => $p->nombre])->values() : []),
    'formaciones' => old('formaciones', $item ? $item->formaciones->map(fn ($f) => ['titulo' => $f->titulo, 'institucion' => $f->institucion, 'anio' => $f->anio])->values() : []),
  ];
@endphp

@section('content')
  <h1 class="h3 fw-bold mb-4">{{ $item ? 'Editar especialista' : 'Nuevo especialista' }}</h1>

  <form method="POST" enctype="multipart/form-data" class="card border-0 shadow-sm p-4"
        action="{{ $item ? route('admin.specialists.update', $item) : route('admin.specialists.store') }}">
    @csrf
    @if($item) @method('PUT') @endif

    <div class="row g-4">
      <div class="col-md-4 text-center">
        <img id="preview" src="{{ $item ? $item->foto_url : '' }}"
             class="rounded-circle mb-3 shadow-sm {{ $item ? '' : 'd-none' }}" width="150" height="150" style="object-fit:cover" alt="">
        <label class="form-label d-block">Foto</label>
        <input type="file" name="foto" accept="image/*" class="form-control" data-preview="#preview">
        <div class="form-text">Máximo 2 MB.</div>
      </div>

      <div class="col-md-8">
        <div class="row g-3">
          <div class="col-12">
            <label class="form-label">Nombre completo</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $item?->nombre) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Cargo</label>
            <input type="text" name="cargo" class="form-control" placeholder="Médico Psiquiatra" value="{{ old('cargo', $item?->cargo) }}" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Área de enfoque</label>
            <input type="text" name="area" class="form-control" placeholder="Psiquiatría Perinatal" value="{{ old('area', $item?->area) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">Idiomas</label>
            <input type="text" name="idiomas" class="form-control" placeholder="Español, Inglés" value="{{ old('idiomas', $item?->idiomas) }}">
          </div>
          <div class="col-md-6">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="telefono_whatsapp" class="form-control" placeholder="5214611234567" value="{{ old('telefono_whatsapp', $item?->telefono_whatsapp) }}">
          </div>
          <div class="col-12">
            <label class="form-label">Ubicación / modalidad</label>
            <input type="text" name="ubicacion" class="form-control" value="{{ old('ubicacion', $item?->ubicacion) }}">
          </div>
          <div class="col-12">
            <label class="form-label">Acerca de mí</label>
            <textarea name="biografia" rows="5" class="form-control">{{ old('biografia', $item?->biografia) }}</textarea>
          </div>
          <div class="col-12">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" name="activo" id="activo" value="1" {{ $activo ? 'checked' : '' }}>
              <label class="form-check-label" for="activo">Visible en la página pública</label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <hr class="my-4">

    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 fw-bold mb-0"><i class="bi bi-briefcase text-primary me-1"></i>Servicios y tratamientos</h2>
      <button type="button" class="btn btn-sm btn-outline-primary agregar" data-lista="servicios"><i class="bi bi-plus-lg me-1"></i>Agregar</button>
    </div>
    <div id="lista-servicios"></div>

    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
      <h2 class="h5 fw-bold mb-0"><i class="bi bi-heart-pulse text-primary me-1"></i>Padecimientos atendidos</h2>
      <button type="button" class="btn btn-sm btn-outline-primary agregar" data-lista="padecimientos"><i class="bi bi-plus-lg me-1"></i>Agregar</button>
    </div>
    <div id="lista-padecimientos"></div>

    <div class="d-flex justify-content-between align-items-center mb-2 mt-4">
      <h2 class="h5 fw-bold mb-0"><i class="bi bi-mortarboard text-primary me-1"></i>Formación y certificaciones</h2>
      <button type="button" class="btn btn-sm btn-outline-primary agregar" data-lista="formaciones"><i class="bi bi-plus-lg me-1"></i>Agregar</button>
    </div>
    <div id="lista-formaciones"></div>

    <div class="d-flex justify-content-end gap-2 mt-4">
      <a href="{{ route('admin.specialists.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar</button>
    </div>
  </form>
@endsection

@section('scripts')
<script>
$(function () {
  const ini = @json($ini);
  const contador = { servicios: 0, padecimientos: 0, formaciones: 0 };
  const quitar = '<div class="col-1 text-end"><button type="button" class="btn btn-sm btn-outline-danger quitar"><i class="bi bi-x-lg"></i></button></div>';
  const input = 'class="form-control form-control-sm"';

  const plantillas = {
    servicios: i => `<div class="row g-2 mb-2 fila align-items-center">
      <div class="col-7"><input type="text" name="servicios[${i}][nombre]" ${input} placeholder="Servicio o tratamiento" required></div>
      <div class="col-4"><input type="number" step="0.01" min="0" name="servicios[${i}][precio]" ${input} placeholder="Precio (opcional)"></div>
      ${quitar}</div>`,
    padecimientos: i => `<div class="row g-2 mb-2 fila align-items-center">
      <div class="col-11"><input type="text" name="padecimientos[${i}][nombre]" ${input} placeholder="Padecimiento" required></div>
      ${quitar}</div>`,
    formaciones: i => `<div class="row g-2 mb-2 fila align-items-center">
      <div class="col-5"><input type="text" name="formaciones[${i}][titulo]" ${input} placeholder="Título o certificación" required></div>
      <div class="col-4"><input type="text" name="formaciones[${i}][institucion]" ${input} placeholder="Institución"></div>
      <div class="col-2"><input type="number" name="formaciones[${i}][anio]" ${input} placeholder="Año"></div>
      ${quitar}</div>`,
  };

  function agregar(lista, datos) {
    const $f = $(plantillas[lista](contador[lista]++));
    // Rellena cada input según la clave que aparece al final de su name
    $f.find('input').each(function () {
      const clave = $(this).attr('name').match(/\[(\w+)\]$/)[1];
      $(this).val(datos?.[clave] ?? '');
    });
    $('#lista-' + lista).append($f);
  }

  $('.agregar').on('click', function () { agregar($(this).data('lista')); });
  $(document).on('click', '.quitar', function () { $(this).closest('.fila').remove(); });

  Object.keys(ini).forEach(l => (ini[l] || []).forEach(d => agregar(l, d)));
});
</script>
@endsection