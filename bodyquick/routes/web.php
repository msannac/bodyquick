<?php
// filepath: c:\xampp\htdocs\bodyquick\bodyquick\routes\web.php
// routes/web.php
// Este archivo contiene las rutas web de la aplicación Laravel.
// Las rutas web son aquellas que se utilizan para servir vistas y manejar solicitudes HTTP
// desde el navegador. En este caso, se utiliza para servir la vista de bienvenida y una ruta API de prueba.
// Se utiliza el espacio de nombres 'Illuminate\Support\Facades\Route' para definir las rutas.
// Se utiliza el espacio de nombres 'Illuminate\Http\Request' para manejar las solicitudes HTTP.
// Se utiliza el espacio de nombres 'Illuminate\Support\Facades\Route' para definir las rutas.
// Se utiliza el espacio de nombres 'Illuminate\Http\Request' para manejar las solicitudes HTTP.
// Se utiliza el espacio de nombres 'Illuminate\Support\Facades\Route' para definir las rutas.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Redirige a reservas.create en lugar de cargar una vista de dashboard
    Route::get('/dashboard', function () {
        return redirect()->route('reservas.create');
    })->name('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reservas/create', [ReservationController::class, 'create'])->name('reservas.create');
    Route::post('/reservas', [ReservationController::class, 'store'])->name('reservas.store');
});
