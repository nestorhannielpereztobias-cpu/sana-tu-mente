<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'SanaTuMente - Salud Mental y Medicina del Sueño')</title>
  
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

  <style>
    html {
      scroll-behavior: smooth;
    }
    section {
      scroll-margin-top: 75px;
      padding: 80px 0;
    }
    .hero-section {
      background: linear-gradient(135deg, #0d6efd 0%, #0a4294 100%);
      color: white;
      padding: 100px 0 70px;
    }
    .card-specialist img {
      width: 130px;
      height: 130px;
      object-fit: cover;
    }

    /* ===== Efectos globales ===== */

/* Botones: se elevan ligeramente */
.btn {
  transition: transform .25s ease, box-shadow .25s ease, background-color .25s ease, color .25s ease;
}
.btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 .5rem 1rem rgba(0,0,0,.15);
}
.btn:active { transform: translateY(0); }

/* Flecha del botón "Regresar" se mueve a la izquierda */
.btn .bi-arrow-left { display: inline-block; transition: transform .25s ease; }
.btn:hover .bi-arrow-left { transform: translateX(-4px); }

/* Navbar: subrayado animado en los links (excepto el botón Contacto) */
.navbar { transition: padding .3s ease, box-shadow .3s ease; }
.navbar.scrolled { padding-top: .35rem; padding-bottom: .35rem; box-shadow: 0 .5rem 1rem rgba(0,0,0,.25) !important; }
.navbar .nav-link:not(.btn) { position: relative; }
.navbar .nav-link:not(.btn)::after {
  content: '';
  position: absolute;
  left: .5rem; right: .5rem; bottom: 2px;
  height: 2px;
  background: #0d6efd;
  transform: scaleX(0);
  transform-origin: left;
  transition: transform .3s ease;
}
.navbar .nav-link:not(.btn):hover::after { transform: scaleX(1); }

/* Tarjetas: se levantan y la sombra toma tono azul */
.card-hover {
  transition: transform .3s ease, box-shadow .3s ease;
}
.card-hover:hover {
  transform: translateY(-8px);
  box-shadow: 0 1rem 2rem rgba(13,110,253,.18) !important; /* !important porque shadow-sm de Bootstrap lo usa */
}

/* Iconos de Misión/Visión/Valores: crecen un poco */
.card-hover .fs-1 i { display: inline-block; transition: transform .3s ease; }
.card-hover:hover .fs-1 i { transform: scale(1.15) rotate(-6deg); }

/* Especialistas: la foto hace zoom suave */
.card-specialist img {
  transition: transform .4s ease, box-shadow .4s ease;
}
.card-specialist:hover img {
  transform: scale(1.08);
  box-shadow: 0 0 0 4px rgba(13,110,253,.25) !important;
}

/* Hero: entrada suave del título */
.hero-section h1 { animation: fadeUp .8s ease both; }

/* Aparición al hacer scroll (usa animation para no chocar con el hover) */
.reveal { opacity: 0; }
.reveal.visible { opacity: 1; animation: fadeUp .6s ease backwards; }

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(24px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Accesibilidad: respeta a quien desactiva animaciones */
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation: none !important; transition: none !important; }
  .reveal { opacity: 1; }
}

    @yield('extra-styles')
  </style>
</head>
<body class="bg-light text-dark">

  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ url('/') }}">
        <i class="bi bi-heart-pulse-fill text-primary me-2"></i>Sana tu mente 
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav gap-2">
          <li class="nav-item"><a class="nav-link" href="{{ url('/#quienes-somos') }}">¿Quiénes somos?</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#especialistas') }}">Especialistas</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#blog') }}">Blog</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/#escalas') }}">Evaluate</a></li>
          <li class="nav-item"><a class="nav-link btn btn-primary text-white px-3" href="{{ url('/#contacto') }}">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  @yield('content')

  <!-- FOOTER -->
  <footer class="bg-dark text-white-50 text-center py-4 border-top border-secondary">
    <div class="container">
      <small>&copy; {{ date('Y') }} Sana Tu Mente. Todos los derechos reservados.</small>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
$(function () {
  // Navbar se compacta al hacer scroll
  const $nav = $('.navbar');
  $(window).on('scroll', function () {
    $nav.toggleClass('scrolled', $(this).scrollTop() > 50);
  }).trigger('scroll');

  // Elementos que aparecen al entrar en pantalla
  const $items = $('section h2, section .card, main .card, section .col-lg-10');
  $items.addClass('reveal').each(function () {
    // Retraso escalonado entre tarjetas hermanas
    const delay = $(this).parent().children('.reveal, [class*="col-"]').index(this) * 120;
    $(this).css('animation-delay', Math.max(delay, 0) + 'ms');
  });

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        $(e.target).addClass('visible');
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.15 });

  $items.each(function () { observer.observe(this); });
});
</script>
  @yield('scripts')
</body>
</html>