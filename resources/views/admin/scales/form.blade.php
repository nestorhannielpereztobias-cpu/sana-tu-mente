@extends('admin.layouts.admin')
@section('title', $item ? 'Editar escala' : 'Nueva escala')

@section('content')
  <h1 class="h3 fw-bold mb-4">{{ $item ? 'Editar escala' : 'Nueva escala' }}</h1>

  <form method="POST" class="card border-0 shadow-sm p-4"
        action="{{ $item ? route('admin.scales.update', $item['id']) : route('admin.scales.store') }}">
    @csrf
    @if($item) @method('PUT') @endif

    {{-- Datos generales --}}
    <div class="row g-3 mb-4">
      <div class="col-12">
        <label class="form-label">Nombre de la escala</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', data_get($item, 'name')) }}" required>
      </div>
      <div class="col-12">
        <label class="form-label">Descripción / instrucciones</label>
        <textarea name="description" rows="2" class="form-control">{{ old('description', data_get($item, 'description')) }}</textarea>
      </div>
    </div>

    {{-- Preguntas --}}
    <div class="d-flex justify-content-between align-items-center mb-2">
      <h2 class="h5 fw-bold mb-0"><i class="bi bi-question-circle text-primary me-1"></i>Preguntas</h2>
      <button type="button" id="addQuestion" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-lg me-1"></i>Agregar pregunta</button>
    </div>
    <p class="text-muted small">Cada pregunta tiene 5 respuestas. Puedes cambiar el texto y los puntos de cada una.</p>
    <div id="questions"></div>

    {{-- Rangos de resultado --}}
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

  {{-- Plantilla de pregunta --}}
  <template id="tpl-question">
    <div class="card border mb-3 q-item">
      <div class="card-header bg-light d-flex justify-content-between align-items-center">
        <strong class="q-title">Pregunta</strong>
        <button type="button" class="btn btn-sm btn-outline-danger q-remove"><i class="bi bi-trash"></i></button>
      </div>
      <div class="card-body">
        <input type="text" name="questions[__Q__][text]" class="form-control mb-3" placeholder="Texto de la pregunta" required>
        <div class="row g-2 small fw-semibold text-muted mb-1"><div class="col-9">Respuesta</div><div class="col-3">Puntos</div></div>
        <div class="a-list"></div>
      </div>
    </div>
  </template>
@endsection

@section('scripts')
<script>
$(function () {
  const defaults = ['Nunca', 'Casi nunca', 'A veces', 'Casi siempre', 'Siempre'];
  const initialQuestions = @json(old('questions', data_get($item, 'questions', [])));
  const initialRanges    = @json(old('ranges', data_get($item, 'ranges', [])));
  let qIndex = 0, rIndex = 0;

  function renumber() {
    $('#questions .q-item').each((n, el) => $(el).find('.q-title').text('Pregunta ' + (n + 1)));
  }

  function addQuestion(q) {
    const i = qIndex++;
    const $q = $($('#tpl-question').html().replaceAll('__Q__', i));
    $q.find('input').first().val(q?.text ?? '');

    const $list = $q.find('.a-list');
    for (let j = 0; j < 5; j++) {
      const a = q?.answers?.[j] ?? { label: defaults[j], points: j + 1 };
      const $row = $(`
        <div class="row g-2 mb-2">
          <div class="col-9"><input type="text" name="questions[${i}][answers][${j}][label]" class="form-control form-control-sm" required></div>
          <div class="col-3"><input type="number" name="questions[${i}][answers][${j}][points]" class="form-control form-control-sm" required></div>
        </div>`);
      $row.find('input').eq(0).val(a.label);
      $row.find('input').eq(1).val(a.points);
      $list.append($row);
    }
    $('#questions').append($q);
    renumber();
  }

  function addRange(r) {
    const k = rIndex++;
    const $row = $(`
      <div class="row g-2 mb-2 r-item align-items-center">
        <div class="col-3 col-md-2"><input type="number" name="ranges[${k}][min]" class="form-control form-control-sm" placeholder="Desde" required></div>
        <div class="col-3 col-md-2"><input type="number" name="ranges[${k}][max]" class="form-control form-control-sm" placeholder="Hasta" required></div>
        <div class="col-6 col-md-7"><input type="text" name="ranges[${k}][text]" class="form-control form-control-sm" placeholder="Mensaje / resultado" required></div>
        <div class="col-12 col-md-1 text-end"><button type="button" class="btn btn-sm btn-outline-danger r-remove"><i class="bi bi-x-lg"></i></button></div>
      </div>`);
    $row.find('input').eq(0).val(r?.min ?? '');
    $row.find('input').eq(1).val(r?.max ?? '');
    $row.find('input').eq(2).val(r?.text ?? '');
    $('#ranges').append($row);
  }

  $('#addQuestion').on('click', () => addQuestion());
  $('#addRange').on('click', () => addRange());
  $(document).on('click', '.q-remove', function () { $(this).closest('.q-item').remove(); renumber(); });
  $(document).on('click', '.r-remove', function () { $(this).closest('.r-item').remove(); });

  // Carga inicial (edición o primera vez)
  if (initialQuestions.length) initialQuestions.forEach(addQuestion); else addQuestion();
  if (initialRanges.length) initialRanges.forEach(addRange); else addRange();
});
</script>
@endsection