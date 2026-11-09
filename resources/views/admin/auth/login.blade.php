<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="noindex, nofollow">
  <title>Acceso - Admin SanaTuMente</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <style>
    body { background: linear-gradient(135deg, #0d6efd 0%, #0a4294 100%); min-height: 100vh; }
    .login-card { max-width: 400px; animation: fadeUp .6s ease both; }
    @keyframes fadeUp { from { opacity: 0; transform: translateY(24px); } to { opacity: 1; transform: none; } }
  </style>
</head>
<body class="d-flex align-items-center justify-content-center p-3">
  <div class="card login-card w-100 border-0 shadow-lg p-4">
    <div class="text-center mb-4">
      <i class="bi bi-shield-lock-fill text-primary display-4"></i>
      <h1 class="h4 fw-bold mt-2 mb-0">Acceso administrativo</h1>
      <small class="text-muted">Sana tu mente</small>
    </div>

    @error('credenciales')
      <div class="alert alert-danger py-2">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <div class="mb-3">
        <label class="form-label">Usuario</label>
        <input type="text" name="user" value="{{ old('user') }}" class="form-control" required autofocus>
      </div>
      <div class="mb-4">
        <label class="form-label">Contraseña</label>
        <div class="input-group">
          <input type="password" name="password" id="password" class="form-control" required>
          <button type="button" class="btn btn-outline-secondary" id="togglePass"><i class="bi bi-eye"></i></button>
        </div>
      </div>
      <button class="btn btn-primary w-100 fw-bold">Entrar</button>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script>
    $('#togglePass').on('click', function () {
      const $i = $('#password');
      const show = $i.attr('type') === 'password';
      $i.attr('type', show ? 'text' : 'password');
      $(this).find('i').toggleClass('bi-eye bi-eye-slash');
    });
  </script>
</body>
</html>