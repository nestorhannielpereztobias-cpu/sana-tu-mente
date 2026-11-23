@extends('layouts.app')

@section('title', 'Perfil Profesional - ' . $especialista->nombre)

@section('extra-styles')
  .profile-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a4294 100%);
    color: white;
    padding: 90px 0 40px;
  }
  .profile-img {
    width: 170px;
    height: 170px;
    object-fit: cover;
    border: 4px solid #ffffff;
    transition: transform .4s ease;
  }
  .profile-img:hover { transform: scale(1.05) rotate(2deg); }
  .sticky-card { position: sticky; top: 90px; }
@endsection

@section('content')
  <header class="profile-header shadow-sm">
    <div class="container">
      <a href="{{ url('/#especialistas') }}" class="btn btn-outline-light btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i> Regresar al inicio
      </a>
      <div class="row align-items-center">
        <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
          <img src="{{ $especialista->foto_url }}" alt="Foto {{ $especialista->nombre }}" class="rounded-circle profile-img shadow">
        </div>
        <div class="col text-center text-md-start">
          @if($especialista->area)
            <span class="badge bg-light text-primary px-3 py-2 rounded-pill fw-semibold mb-2">{{ $especialista->area }}</span>
          @endif
          <h1 class="h2 fw-bold mb-1">{{ $especialista->nombre }}</h1>
          <p class="mb-1 opacity-90">{{ $especialista->cargo }}</p>
          @if($especialista->ubicacion)
            <p class="mb-1 opacity-90"><i class="bi bi-geo-alt-fill me-1"></i>{{ $especialista->ubicacion }}</p>
          @endif
          @if($especialista->idiomas)
            <p class="mb-0 opacity-90"><i class="bi bi-translate me-1"></i>{{ $especialista->idiomas }}</p>
          @endif
        </div>
      </div>
    </div>
  </header>

  <main class="container my-5">
    <div class="row g-4">
      <div class="col-lg-8">

        @if($especialista->biografia)
          <div class="card border-0 shadow-sm p-4 mb-4">
            <h2 class="h5 fw-bold text-primary mb-3">Acerca de mí</h2>
            <p class="text-muted mb-0">{{ $especialista->biografia }}</p>
          </div>
        @endif

        @if($especialista->servicios->isNotEmpty())
          <div class="card border-0 shadow-sm p-4 mb-4">
            <h2 class="h5 fw-bold text-primary mb-3">Servicios y tratamientos</h2>
            <ul class="list-group list-group-flush">
              @foreach($especialista->servicios as $s)
                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                  <span><i class="bi bi-check2-circle text-primary me-2"></i>{{ $s->nombre }}</span>
                  @if($s->precio !== null)
                    <span class="fw-semibold">${{ number_format($s->precio, 2) }} MXN</span>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>
        @endif

        @if($especialista->padecimientos->isNotEmpty())
          <div class="card border-0 shadow-sm p-4 mb-4">
            <h2 class="h5 fw-bold text-primary mb-3">Padecimientos que atiendo</h2>
            <div class="d-flex flex-wrap gap-2">
              @foreach($especialista->padecimientos as $p)
                <span class="badge bg-primary-subtle text-primary fs-6 fw-normal px-3 py-2">{{ $p->nombre }}</span>
              @endforeach
            </div>
          </div>
        @endif

        @if($especialista->formaciones->isNotEmpty())
          <div class="card border-0 shadow-sm p-4 mb-4">
            <h2 class="h5 fw-bold text-primary mb-3">Formación y certificaciones</h2>
            <ul class="list-unstyled mb-0">
              @foreach($especialista->formaciones as $f)
                <li class="mb-2">
                  <i class="bi bi-mortarboard text-primary me-2"></i><strong>{{ $f->titulo }}</strong>
                  @if($f->institucion || $f->anio)
                    <br><small class="text-muted ms-4">{{ $f->institucion }}{{ $f->institucion && $f->anio ? ' · ' : '' }}{{ $f->anio }}</small>
                  @endif
                </li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>

      <div class="col-lg-4">
        <div class="sticky-card">
          <div class="card border-0 shadow-sm p-4">
            <h3 class="h5 fw-bold mb-3">Agendar Cita</h3>
            @if($especialista->telefono_whatsapp)
              <a href="https://wa.me/{{ $especialista->telefono_whatsapp }}?text={{ rawurlencode('Hola, quisiera agendar una cita con ' . $especialista->nombre) }}"
                 target="_blank" rel="noopener" class="btn btn-success w-100 fw-bold">
                <i class="bi bi-whatsapp me-2"></i>WhatsApp
              </a>
            @else
              <p class="text-muted small mb-0">Contáctanos desde la sección de contacto.</p>
            @endif
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection