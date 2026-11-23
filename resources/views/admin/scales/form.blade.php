@extends('admin.layouts.admin')
@section('title', $item ? 'Editar escala' : 'Nueva escala')

@php
  $activa = old() ? (bool) old('activa') : ($item->activa ?? true);
  $preguntasIni = old('preguntas', $item
    ? $item->preguntas->map(fn ($p) => [
        'texto' => $p->texto,
        'respuestas' => $p->respuestas->map(fn ($r) => ['texto' => $r->texto])->values(),
      ])->values()
    : []);
  $rangosIni = old('rangos', $item
    ? $item->rangos->map(fn ($r) => ['minimo' => $r->minimo, 'maximo' => $r->maximo, 'texto' => $r->texto])->values()
    : []);
@endphp

@section('content')
  <h1 class="h3 fw-bold mb-4">{{ $item ? 'Editar escala' : 'Nueva escala' }}</h1>

  <form method="POST" class="card border-0 shadow-sm p-4"
        action="{{ $item ? route('admin.scales.update', $item) : route('admin.scales.store') }}">
    @csrf
    @if($item) @method('PUT') @endif

    <div class="row g-3 mb-4">
      <div class="col-12">
        <label class="form-label">Nombre de la escala</label>
        <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $item?->nombre) }}" required>
      </div>
      <div class="col-12">
        <label class="form-label">Descripción / instrucciones</label>
        <textarea name="descripcion" rows="2" class="form-control">{{ old('descripcion', $item?->descripcion) }}</textarea>
      </div>
      <div class="col-12">
        <div class="form-check form-switch">
          <input class="form-check-input" type="checkbox" name="activa" id="activa" value="1" {{ $activa ? 'checked' : '' }}>
          <label class="form-check-label" for="activa">Visible en la página pública</label>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 fw-bold mb-0"><i class="bi bi-question-circle text-primary me-1"></i>Preguntas</h2>
      <button type="button" id="addQuestion" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-lg me-1"></i>Agregar pregunta</button>
    </div>
    <p class="text-muted small">Cada pregunta tiene 5 respuestas. La primera vale 1 punto y la quinta vale 5.</p>
    <div id="questions"></div>

    <hr class="my-4">
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 fw-bold mb-0"><i class="bi bi-bar-chart-steps text-primary me-1"></i>Interpretación del resultado</h2>
      <button type="button" id="addRange" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-lg me-1"></i>Agregar rango</button>
    </div>
    <p class="text-muted small">Según el puntaje total, se mostrará al usuario el mensaje del rango que corresponda.</p>
    <div id="ranges"></div>

    <div class="d-flex justify-content-end gap-2 mt-4">
      <a href="{{ route('admin.scales.index') }}" class="btn btn-outline-secondary">Cancelar</a>
      <button class="btn btn-primary"><i class="bi bi-save me-1"></i>Guardar escala</button>
    </div>
  </form>
@endsection

@section('scripts')
<script>
$(function () {
  const porDefecto = ['Nunca', 'Pocas veces', 'A veces', 'Casi siempre', 'Siempre'];
  const preguntasIni = @json($preguntasIni);
  const rangosIni = @json($rangosIni);
  let qIndex = 0, rIndex = 0;

  function renumerar() {
    $('#questions .q-item').each((n, el) => $(el).find('.q-title').text('Pregunta ' + (n + 1)));
  }

  function agregarPregunta(q) {
    const i = qIndex++;
    const $q = $(`
      <div class="card border mb-3 q-item">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
          <strong class="q-title">Pregunta</strong>
          <button type="button" class="btn btn-sm btn-outline-danger q-remove"><i class="bi bi-trash"></i></button>
        </div>
        <div class="card-body">
          <input type="text" name="preguntas[${i}][texto]" class="form-control mb-3 q-texto" placeholder="Texto de la pregunta" required>
          <div class="a-list"></div>
        </div>
      </div>`);
    $q.find('.q-texto').val(q?.texto ?? '');

    for (let j = 0; j < 5; j++) {
      const $fila = $(`
        <div class="input-group input-group-sm mb-2">
          <span class="input-group-text" style="width:70px">${j + 1} pt</span>
          <input type="text" name="preguntas[${i}][respuestas][${j}][texto]" class="form-control" required>
        </div>`);
      $fila.find('input').val(q?.respuestas?.[j]?.texto ?? porDefecto[j]);
      $q.find('.a-list').append($fila);
    }

    $('#questions').append($q);
    renumerar();
  }

  function agregarRango(r) {
    const k = rIndex++;
    const $row = $(`
      <div class="row g-2 mb-2 r-item align-items-center">
        <div class="col-3 col-md-2"><input type="number" name="rangos[${k}][minimo]" class="form-control form-control-sm" placeholder="Desde" required></div>
        <div class="col-3 col-md-2"><input type="number" name="rangos[${k}][maximo]" class="form-control form-control-sm" placeholder="Hasta" required></div>
        <div class="col-6 col-md-7"><input type="text" name="rangos[${k}][texto]" class="form-control form-control-sm" placeholder="Mensaje / resultado" required></div>
        <div class="col-12 col-md-1 text-end"><button type="button" class="btn btn-sm btn-outline-danger r-remove"><i class="bi bi-x-lg"></i></button></div>
      </div>`);
    $row.find('input').eq(0).val(r?.minimo ?? '');
    $row.find('input').eq(1).val(r?.maximo ?? '');
    $row.find('input').eq(2).val(r?.texto ?? '');
    $('#ranges').append($row);
  }

  $('#addQuestion').on('click', () => agregarPregunta());
  $('#addRange').on('click', () => agregarRango());
  $(document).on('click', '.q-remove', function () { $(this).closest('.q-item').remove(); renumerar(); });
  $(document).on('click', '.r-remove', function () { $(this).closest('.r-item').remove(); });

  if (preguntasIni.length) preguntasIni.forEach(agregarPregunta); else agregarPregunta();
  if (rangosIni.length) rangosIni.forEach(agregarRango); else agregarRango();
});
</script>
@endsection