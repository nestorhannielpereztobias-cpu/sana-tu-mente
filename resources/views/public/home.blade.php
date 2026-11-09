@extends('layouts.app')

@section('title', 'SanaTuMente - Inicio')

@section('content')
  <header class="hero-section text-center">
    <div class="container">
      <h1 class="display-5 fw-bold">Atención especializada en salud mental y medicina del sueño</h1>
    </div>
  </header>

  <section id="quienes-somos" class="bg-white">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">¿Quiénes Somos?</h2>
        <div class="mx-auto bg-primary mb-3" style="height: 3px; width: 60px;"></div>
      </div>

      <div class="row justify-content-center mb-5">
        <div class="col-lg-10 text-center">
          <h3 class="h4 fw-semibold text-primary mb-3">Acerca de nosotros</h3>
          <p class="fs-5 text-muted leading-relaxed">
            Somos un equipo multidisciplinario de profesionales dedicados al diagnóstico, tratamiento, prevención y cuidado de la salud mental. Trabajamos con un enfoque humano y basado en evidencia científica para brindarte herramientas prácticas orientadas a mejorar tu calidad de vida.
          </p>
        </div>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card card-hover h-100 border-0 shadow-sm text-center p-4">
            <div class="text-primary fs-1 mb-3"><i class="bi bi-bullseye"></i></div>
            <h4 class="card-title fw-bold">Misión</h4>
            <p class="card-text text-muted">
              Brindar atención integral en psiquiatría general, psiquiatría perinatal, medicina del sueño y psicoterapia basada en evidencia científica, mediante un servicio de excelencia, ético, humano y personalizado, orientado a facilitar procesos de cambio, recuperación y bienestar, respetando las necesidades particulares de cada paciente.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card card-hover h-100 border-0 shadow-sm text-center p-4">
            <div class="text-primary fs-1 mb-3"><i class="bi bi-eye"></i></div>
            <h4 class="card-title fw-bold">Visión</h4>
            <p class="card-text text-muted">
              Ser un centro de referencia en salud mental integral, reconocido por la excelencia en psiquiatría general, psiquiatría perinatal, medicina del sueño y atención psicológica, distinguiéndose por una práctica ética, humana, personalizada y sustentada en la evidencia científica, que contribuya al bienestar y a una mejor calidad de vida de nuestros pacientes.
            </p>
          </div>
        </div>

        <div class="col-md-4">
          <div class="card card-hover h-100 border-0 shadow-sm text-center p-4">
            <div class="text-primary fs-1 mb-3"><i class="bi bi-shield-check"></i></div>
            <h4 class="card-title fw-bold">Valores</h4>
            <ul class="list-unstyled text-muted text-start d-inline-block">
              <li><i class="bi bi-check2 text-primary me-2"></i>Ética profesional</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Excelencia</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Evidencia científica</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Atención personalizada</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Empatía y trato humano</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Respeto</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Compromiso</li>
              <li><i class="bi bi-check2 text-primary me-2"></i>Trabajo interdisciplinario</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="especialistas" class="bg-light">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Nuestros Especialistas</h2>
        <div class="mx-auto bg-primary mb-3" style="height: 3px; width: 60px;"></div>
        <p class="text-muted">Conoce a nuestro equipo clínico especializado</p>
      </div>

      <div class="mb-5">
        <h3 class="h4 fw-bold text-dark border-bottom pb-2 mb-4">
          <i class="bi bi-clipboard2-pulse text-primary me-2"></i>Psiquiatras
        </h3>
        <div class="row g-4">
          <div class="col-sm-6 col-lg-4">
            <div class="card card-specialist h-100 text-center border-0 shadow-sm p-4">
              <img src="{{ asset('images/doctoraDianaPerez.webp') }}" class="rounded-circle mx-auto mb-3 shadow-sm" alt="Foto Dra. Diana Pérez" onerror="this.src='https://via.placeholder.com/130'">
              <h5 class="card-title fw-bold mb-1">Dra. Diana Pérez</h5>
              <p class="text-primary small mb-3">Médico Psiquiatra</p>
              <a href="{{ route('especialistas.show', 'diana-perez') }}" class="btn btn-outline-primary btn-sm mt-auto">Ver Perfil</a>
            </div>
          </div>
          <div class="col-sm-6 col-lg-4">
            <div class="card card-specialist h-100 text-center border-0 shadow-sm p-4">
              <img src="{{ asset('images/doctorAndresBarrera.jpg') }}" class="rounded-circle mx-auto mb-3 shadow-sm" alt="Foto Dr. Andrés Barrera" onerror="this.src='https://via.placeholder.com/130'">
              <h5 class="card-title fw-bold mb-1">Dr. Andrés Barrera</h5>
              <p class="text-primary small mb-3">Doctor Sueño</p>
              <a href="#" class="btn btn-outline-primary btn-sm mt-auto">Ver Perfil</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="blog" class="bg-white">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold">Blog</h2>
        <div class="mx-auto bg-primary mb-3" style="height: 3px; width: 60px;"></div>
        <p class="text-muted">Artículos y contenido audiovisual para tu bienestar.</p>
      </div>
      <div class="row g-4">
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body">
              <span class="badge bg-primary-subtle text-primary mb-2">Artículo</span>
              <h5 class="card-title fw-bold">Guía básica de Mindfulness</h5>
              <p class="card-text text-muted small">Técnicas sencillas para reducir el estrés en tu rutina diaria.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="escalas" class="bg-light">
    <div class="container text-center">
      <h2 class="fw-bold mb-3">Evaluate</h2>
      <p class="text-muted">Pruebas interactivas de tamizaje psicológico y medicina del sueño.</p>
    </div>
  </section>

  <section id="contacto" class="bg-white">
    <div class="container text-center">
      <h2 class="fw-bold mb-3">Contacto</h2>
      <p class="text-muted">+52 (461) 157-8082 | Hospital San José, Consultorio 517, Celaya, Guanajuato</p>
    </div>
  </section>
@endsection