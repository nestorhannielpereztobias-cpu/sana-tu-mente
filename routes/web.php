<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('public.home');
})->name('home');

Route::get('/especialistas/{slug}', function ($slug) {
    return view('public.specialists.show', ['slug' => $slug]);
})->name('especialistas.show');


// ---- Datos de ejemplo (se reemplazan por BD después) ----
$answers = array_map(
    fn ($l, $p) => ['label' => $l, 'points' => $p],
    ['Nunca', 'Casi nunca', 'A veces', 'Casi siempre', 'Siempre'],
    [1, 2, 3, 4, 5]
);

$demo = [
    'specialists' => [
        ['id' => 1, 'name' => 'Dra. Diana Pérez', 'title' => 'Médico Psiquiatra', 'area' => 'Psiquiatría Perinatal',
         'location' => 'Guanajuato, México | Atención Presencial y Online', 'phone' => '5214611578082',
         'bio' => 'Soy médico especialista en psiquiatría sumamente interesada en la psiquiatría perinatal...',
         'photo' => 'doctoraDianaPerez.webp', 'active' => true],
        ['id' => 2, 'name' => 'Dr. Andrés Barrera', 'title' => 'Doctor Sueño', 'area' => 'Medicina del Sueño',
         'location' => 'Celaya, Guanajuato', 'phone' => '5214611578082',
         'bio' => 'Especialista en medicina del sueño.', 'photo' => 'doctorAndresBarrera.jpg', 'active' => true],
    ],
    'posts' => [
        ['id' => 1, 'title' => 'Guía básica de Mindfulness', 'content' => 'Técnicas sencillas para reducir el estrés...',
         'image' => null, 'status' => 'published', 'date' => '2026-10-01'],
    ],
    'scales' => [
        ['id' => 1, 'name' => 'Escala de ejemplo', 'description' => 'Tamizaje breve de ejemplo.',
         'questions' => [
             ['text' => 'Me he sentido nervioso o ansioso', 'answers' => $answers],
             ['text' => 'Me ha costado trabajo relajarme', 'answers' => $answers],
         ],
         'ranges' => [
             ['min' => 2, 'max' => 5, 'text' => 'Nivel bajo'],
             ['min' => 6, 'max' => 10, 'text' => 'Nivel alto, consulta a un especialista'],
         ]],
    ],
];


Route::prefix('gestion-stm')->name('admin.')->group(function () use ($demo) {
    // Login / logout
    Route::get('login', fn () => session('admin_auth') ? redirect()->route('admin.dashboard') : view('admin.auth.login'))->name('login');

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

    // Zona protegida
    Route::middleware(\App\Http\Middleware\AdminAuth::class)->group(function () use ($demo) {

        Route::get('/', fn () => view('admin.dashboard', ['counts' => array_map('count', $demo)]))->name('dashboard');

        foreach (['specialists', 'posts', 'scales'] as $res) {
            Route::get($res, fn () => view("admin.$res.index", ['items' => $demo[$res]]))->name("$res.index");
            Route::get("$res/create", fn () => view("admin.$res.form", ['item' => null]))->name("$res.create");
            Route::get("$res/{id}/edit", fn ($id) => view("admin.$res.form", [
                'item' => collect($demo[$res])->firstWhere('id', (int) $id),
            ]))->name("$res.edit");

            $msg = 'Guardado (modo demostración: aún no se guarda en base de datos).';
            Route::post($res, fn () => redirect()->route("admin.$res.index")->with('ok', $msg))->name("$res.store");
            Route::put("$res/{id}", fn () => redirect()->route("admin.$res.index")->with('ok', $msg))->name("$res.update");
            Route::delete("$res/{id}", fn () => redirect()->route("admin.$res.index")->with('ok', 'Eliminado (demo).'))->name("$res.destroy");
        }
    });
});
