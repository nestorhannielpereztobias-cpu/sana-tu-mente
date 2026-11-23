<?php

use App\Http\Controllers\Admin\ArticuloController;
use App\Http\Controllers\Admin\EscalaController;
use App\Http\Controllers\Admin\EspecialistaController;
use App\Http\Middleware\AdminAuth;
use App\Models\Articulo;
use App\Models\Escala;
use App\Models\Especialista;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicoController;

// ---------- Página pública ----------
Route::get('/', [PublicoController::class, 'inicio'])->name('home');

Route::get('/especialistas/{especialista:url_amigable}', [PublicoController::class, 'especialista'])
    ->name('especialistas.show');

Route::get('/blog/{articulo:url_amigable}', [PublicoController::class, 'articulo'])->name('articulos.show');

Route::get('/evaluate/{escala}', [PublicoController::class, 'escala'])->name('escalas.show');
Route::post('/evaluate/{escala}', [PublicoController::class, 'resultadoEscala'])->name('escalas.resultado');

// ---------- Panel administrativo ----------
Route::prefix('gestion-stm')->name('admin.')->group(function () {

    Route::get('login', fn () => session('admin_auth')
        ? redirect()->route('admin.dashboard')
        : view('admin.auth.login'))->name('login');

    Route::post('login', function (Request $request) {
        $request->validate(['user' => 'required', 'password' => 'required']);

        $ok = hash_equals((string) env('ADMIN_USER'), (string) $request->user)
           && hash_equals((string) env('ADMIN_PASSWORD'), (string) $request->password);

        if (! $ok) {
            return back()->withErrors(['credenciales' => 'Usuario o contraseña incorrectos.'])->onlyInput('user');
        }

        $request->session()->regenerate();
        session(['admin_auth' => true]);
        return redirect()->route('admin.dashboard');
    })->middleware('throttle:5,1')->name('login.post');

    Route::post('logout', function (Request $request) {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');

    Route::middleware(AdminAuth::class)->group(function () {

        Route::get('/', fn () => view('admin.dashboard', [
            'counts' => [
                'specialists' => Especialista::count(),
                'posts' => Articulo::count(),
                'scales' => Escala::count(),
            ],
        ]))->name('dashboard');

        Route::resource('specialists', EspecialistaController::class)
            ->parameters(['specialists' => 'especialista'])->except('show');
        Route::resource('posts', ArticuloController::class)
            ->parameters(['posts' => 'articulo'])->except('show');
        Route::resource('scales', EscalaController::class)
            ->parameters(['scales' => 'escala'])->except('show');
    });
});