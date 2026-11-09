<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>@yield('title', 'Panel') - Admin SanaTuMente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    .navbar .nav-link.active { color: #fff; border-bottom: 2px solid #0d6efd; }
    .btn { transition: transform .2s ease, box-shadow .2s ease; }
    .btn:hover { transform: translateY(-2px); box-shadow: 0 .4rem .8rem rgba(0,0,0,.15); }
    .thumb { width: 48px; height: 48px; object-fit: cover; }
  </style>
</head>
<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="{{ route('admin.dashboard') }}">
        <i class="bi bi-gear-fill text-primary me-2"></i>Panel Admin
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="adminNav">
        <ul class="navbar-nav me-auto gap-lg-2">
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Inicio</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.specialists.*') ? 'active' : '' }}" href="{{ route('admin.specialists.index') }}">Especialistas</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">Blog</a></li>
          <li class="nav-item"><a class="nav-link {{ request()->routeIs('admin.scales.*') ? 'active' : '' }}" href="{{ route('admin.scales.index') }}">Escalas</a></li>
        </ul>
        <div class="d-flex gap-2">
          <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-light btn-sm"><i class="bi bi-box-arrow-up-right me-1"></i>Ver sitio</a>
          <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button class="btn btn-danger btn-sm"><i class="bi bi-box-arrow-right me-1"></i>Salir</button>
          </form>
        </div>
      </div>
    </div>
  </nav>

  <main class="container py-4">
    @if(session('ok'))
      <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-1"></i>{{ session('ok') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif
    @if($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
      </div>
    @endif

    @yield('content')
  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    // Confirmación al eliminar
    $(document).on('submit', '.js-delete', function () {
      return confirm('¿Seguro que deseas eliminar este registro? Esta acción no se puede deshacer.');
    });
    // Vista previa de imagen: <input data-preview="#idImg">
    $(document).on('change', 'input[data-preview]', function () {
      const file = this.files[0];
      if (!file) return;
      const reader = new FileReader();
      reader.onload = e => $($(this).data('preview')).attr('src', e.target.result).removeClass('d-none');
      reader.readAsDataURL(file);
    });
  </script>
  @yield('scripts')
</body>
</html>