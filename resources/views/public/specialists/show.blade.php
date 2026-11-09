@extends('layouts.app')

@section('title', 'Perfil Profesional - Dra. Diana Pérez')

@section('extra-styles')
  .profile-header {
    background: linear-gradient(135deg, #0d6efd 0%, #0a4294 100%);
    color: white;
    padding: 60px 0 40px;
  }
  .profile-img {
    width: 170px;
    height: 170px;
    object-fit: cover;
    border: 4px solid #ffffff;
  }
  .sticky-card {
    position: sticky;
    top: 90px;
  }
@endsection

@section('content')
  <header class="profile-header shadow-sm">
    <div class="container">
      <a href="{{ url('/') }}" class="btn btn-outline-light btn-sm mb-4">
        <i class="bi bi-arrow-left me-1"></i> Regresar al inicio
      </a>
      <div class="row align-items-center">
        <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
          <img src="{{ asset('images/doctoraDianaPerez.webp') }}" alt="Foto Dra. Diana Pérez" class="rounded-circle profile-img shadow" onerror="this.src='https://via.placeholder.com/170'">
        </div>
        <div class="col text-center text-md-start">
          <span class="badge bg-light text-primary px-3 py-2 rounded-pill fw-semibold mb-2">Psiquiatría Perinatal</span>
          <h1 class="h2 fw-bold mb-1">Dra. Diana Pérez</h1>
          <p class="mb-2 opacity-90"><i class="bi bi-geo-alt-fill me-1"></i> Guanajuato, México | Atención Presencial y Online</p>
        </div>
      </div>
    </div>
  </header>

  <main class="container my-5">
    <div class="row g-4">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4 mb-4">
          <h2 class="h5 fw-bold text-primary mb-3">Acerca de mí</h2>
          <p class="text-muted leading-relaxed">
            Soy médico especialista en psiquiatría sumamente interesada en la psiquiatría perinatal, porque considero que cuidar la salud mental de las mujeres en esta etapa es vital para hacer vínculos sanos y crianzas positivas.
          </p>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="sticky-card">
          <div class="card border-0 shadow-sm p-4">
            <h3 class="h5 fw-bold mb-3">Agendar Cita</h3>
            <a href="https://wa.me/5214611578082?text=Hola%2C%20quisiera%20agendar%20una%20cita%20con%20la%20Dra.%20Diana%20P%C3%A9rez" target="_blank" class="btn btn-success w-100 fw-bold">
              <i class="bi bi-whatsapp me-2"></i>WhatsApp
            </a>
          </div>
        </div>
      </div>
    </div>
  </main>
@endsection