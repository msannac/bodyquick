<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CitaController;
use App\Http\Controllers\Admin\ActividadController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Cliente\ReservaController;
use App\Http\Controllers\Admin\PerfilController;
use App\Http\Controllers\Cliente\PerfilController as ClientePerfilController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\ClienteMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event;
use App\Http\Controllers\LandingController;


Route::get('/', [LandingController::class, 'index']);


// Rutas de verificación de email (Laravel)
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/'); 
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '¡Enlace de verificación reenviado!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Grupo de rutas para usuarios autenticados y verificados
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Ruta para el dashboard
    /*Route::get('/admin.dashboard', function () {
        if (Auth::check() && !Auth::user()->is_admin) {
            return redirect()->route('cliente.reservas.index');
        }
        $dashboardController = app(App\Http\Controllers\Admin\DashboardController::class);
        return $dashboardController->index();
    })->name('admin.dashboard');*/

    // Rutas protegidas para el área administrativa usando la clase completa de middleware
    Route::middleware([AdminMiddleware::class])->group(function () {
         Route::get('admin/users/create', function () {
             return view('Admin/createUser');
         })->name('admin.users.create');

         Route::get('admin/actividades/create', function () {
             return view('Admin/createActividad');
         })->name('admin.actividades.create');

         // Rutas para el CRUD de citas 
         Route::get('admin/citas', [CitaController::class, 'listar'])->name('admin.citas.listar');
         Route::get('admin/citas/crear', [CitaController::class, 'crear'])->name('admin.citas.crear');
         Route::post('admin/citas', [CitaController::class, 'almacenar'])->name('admin.citas.almacenar');
         Route::get('admin/citas/{cita}/editar', [CitaController::class, 'editar'])->name('admin.citas.editar');
         Route::put('admin/citas/{cita}', [CitaController::class, 'actualizar'])->name('admin.citas.actualizar');
         Route::delete('admin/citas/{cita}', [CitaController::class, 'eliminar'])->name('admin.citas.eliminar');
         Route::get('admin/citas/huecos-disponibles', [CitaController::class, 'huecosDisponibles'])->name('admin.citas.huecosDisponibles');
         Route::get('admin/citas/crear-masiva', [CitaController::class, 'crearMasiva'])->name('admin.citas.crearMasiva');
         Route::post('admin/citas/almacenar-masiva', [CitaController::class, 'almacenarMasiva'])->name('admin.citas.almacenarMasiva');

         // Rutas para el CRUD de actividades 
         Route::get('admin/actividades', [ActividadController::class, 'listar'])->name('admin.actividades.listar');
         Route::get('admin/actividades/crear', [ActividadController::class, 'crear'])->name('admin.actividades.crear');
         Route::post('admin/actividades', [ActividadController::class, 'almacenar'])->name('admin.actividades.almacenar');
         Route::get('admin/actividades/{actividad}/editar', [ActividadController::class, 'editar'])->name('admin.actividades.editar');
         Route::put('admin/actividades/{actividad}', [ActividadController::class, 'actualizar'])->name('admin.actividades.actualizar');
         Route::delete('admin/actividades/{actividad}', [ActividadController::class, 'eliminar'])->name('admin.actividades.eliminar');

         // Rutas para el CRUD de clientes 
         Route::get('admin/clientes', [App\Http\Controllers\Admin\UserController::class, 'listar'])->name('admin.clientes.listar');
         Route::get('admin/clientes/crear', [App\Http\Controllers\Admin\UserController::class, 'crear'])->name('admin.clientes.crear');
         Route::post('admin/clientes', [App\Http\Controllers\Admin\UserController::class, 'almacenar'])->name('admin.clientes.almacenar');
         Route::get('admin/clientes/{cliente}/editar', [App\Http\Controllers\Admin\UserController::class, 'editar'])->name('admin.clientes.editar');
         Route::put('admin/clientes/{cliente}', [App\Http\Controllers\Admin\UserController::class, 'actualizar'])->name('admin.clientes.actualizar');
         Route::delete('admin/clientes/{cliente}', [App\Http\Controllers\Admin\UserController::class, 'eliminar'])->name('admin.clientes.eliminar');

         // Rutas para el CRUD de reservas (admin)
         //Route::prefix('admin/reservas')->group(function () {
             Route::get('/', [App\Http\Controllers\Admin\ReservaController::class, 'index'])->name('admin.reservas.listar');
             Route::get('/crear', [App\Http\Controllers\Admin\ReservaController::class, 'create'])->name('admin.reservas.crear');
             Route::post('/', [App\Http\Controllers\Admin\ReservaController::class, 'store'])->name('admin.reservas.almacenar');
             Route::get('/{reserva}/editar', [App\Http\Controllers\Admin\ReservaController::class, 'edit'])->name('admin.reservas.editar');
             Route::put('/{reserva}', [App\Http\Controllers\Admin\ReservaController::class, 'update'])->name('admin.reservas.actualizar');
             Route::delete('/{reserva}', [App\Http\Controllers\Admin\ReservaController::class, 'destroy'])->name('admin.reservas.eliminar');

             // AJAX
             Route::get('/dias-disponibles', [App\Http\Controllers\Admin\ReservaController::class, 'diasDisponibles'])->name('admin.reservas.diasDisponibles');
             Route::get('/huecos-disponibles', [App\Http\Controllers\Admin\ReservaController::class, 'huecosDisponibles'])->name('admin.reservas.huecosDisponibles');
        // });
         //Route::get('admin/reservas', [App\Http\Controllers\Admin\ReservaController::class, 'index'])->name('admin.reservas.listar');
         //Route::get('admin/reservas/crear', [App\Http\Controllers\Admin\ReservaController::class, 'create'])->name('admin.reservas.crear');
         //Route::post('admin/reservas', [App\Http\Controllers\Admin\ReservaController::class, 'store'])->name('admin.reservas.almacenar');
         //Route::get('admin/reservas/{reserva}/editar', [App\Http\Controllers\Admin\ReservaController::class, 'edit'])->name('admin.reservas.editar');
         //Route::put('admin/reservas/{reserva}', [App\Http\Controllers\Admin\ReservaController::class, 'update'])->name('admin.reservas.actualizar');
         //Route::delete('admin/reservas/{reserva}', [App\Http\Controllers\Admin\ReservaController::class, 'destroy'])->name('admin.reservas.eliminar');

         // Rutas para AJAX de reservas admin (días y huecos disponibles)
         //Route::get('admin/reservas/dias-disponibles', [App\Http\Controllers\Admin\ReservaController::class, 'diasDisponibles'])->name('admin.reservas.diasDisponibles');
         //Route::get('admin/reservas/huecos-disponibles', [App\Http\Controllers\Admin\ReservaController::class, 'huecosDisponibles'])->name('admin.reservas.huecosDisponibles');

         // Rutas para el CRUD de productos (admin)
         Route::get('admin/productos', [App\Http\Controllers\Admin\ProductoController::class, 'listar'])->name('admin.productos.listar');
         Route::get('admin/productos/crear', [App\Http\Controllers\Admin\ProductoController::class, 'crear'])->name('admin.productos.crear');
         Route::post('admin/productos', [App\Http\Controllers\Admin\ProductoController::class, 'guardar'])->name('admin.productos.guardar');
         Route::get('admin/productos/{producto}/editar', [App\Http\Controllers\Admin\ProductoController::class, 'editar'])->name('admin.productos.editar');
         Route::put('admin/productos/{producto}', [App\Http\Controllers\Admin\ProductoController::class, 'actualizar'])->name('admin.productos.actualizar');
         Route::delete('admin/productos/{producto}', [App\Http\Controllers\Admin\ProductoController::class, 'eliminar'])->name('admin.productos.eliminar');
    });

    Route::middleware(['auth'])->prefix('admin')->group(function () {
        Route::get('/perfil/editar', [PerfilController::class, 'edit'])
             ->name('admin.perfil.editar');
        Route::post('/perfil/actualizar', [PerfilController::class, 'update'])
             ->name('admin.perfil.actualizar');
    });
});

// Grupo de rutas para clientes autenticados
Route::middleware(['auth:sanctum', ClienteMiddleware::class])->group(function () {
    Route::get('/cliente/reservas', [ReservaController::class, 'index'])->name('cliente.reservas.index');
    Route::get('/cliente/reservas/nueva', [ReservaController::class, 'create'])->name('cliente.reservas.nueva');
    Route::post('/cliente/reservas', [ReservaController::class, 'store'])->name('cliente.reservas.store');
    Route::get('/cliente/reservas/{reserva}/editar', [ReservaController::class, 'edit'])->name('cliente.reservas.editar');
    Route::put('/cliente/reservas/{reserva}', [ReservaController::class, 'update'])->name('cliente.reservas.update');
    Route::delete('/cliente/reservas/{reserva}', [ReservaController::class, 'destroy'])->name('cliente.reservas.eliminar');
    Route::get('cliente/reservas/dias-disponibles', [ReservaController::class, 'diasDisponibles'])->name('cliente.reservas.diasDisponibles');
    Route::get('cliente/reservas/huecos-disponibles', [ReservaController::class, 'huecosDisponibles'])->name('cliente.reservas.huecosDisponibles');
    Route::post('cliente/reservas/almacenar', [ReservaController::class, 'store'])->name('cliente.reservas.almacenar');

    Route::get('/cliente/perfil/editar', [ClientePerfilController::class, 'edit'])
         ->name('cliente.perfil.editar');
    Route::post('/cliente/perfil/actualizar', [ClientePerfilController::class, 'update'])
         ->name('cliente.perfil.actualizar');
});

// Historial de compras del cliente
Route::middleware(['auth'])->get('/historial-compras', [App\Http\Controllers\PedidoController::class, 'historial'])->name('pedidos.historial');

Route::middleware(['auth'])->group(function () {
    Route::get('/cliente/productos', [App\Http\Controllers\Cliente\ProductoController::class, 'index'])->name('cliente.productos.index');
});

// Carrito
Route::middleware(['auth'])->group(function () {
    Route::get('/carrito', [App\Http\Controllers\CarritoController::class, 'index'])->name('carrito.index');
    Route::post('/carrito/agregar', [App\Http\Controllers\CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::post('/carrito/modificar/{id}', [App\Http\Controllers\CarritoController::class, 'modificar'])->name('carrito.modificar');
    Route::post('/carrito/eliminar/{id}', [App\Http\Controllers\CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    // Ruta AJAX para obtener el contador del carrito
    Route::get('/carrito/contador', [App\Http\Controllers\CarritoController::class, 'contador'])->name('carrito.contador');
    Route::post('/carrito/checkout', [App\Http\Controllers\CarritoController::class, 'checkout'])->name('carrito.checkout');
});

// Stripe checkout success/cancel
Route::get('/checkout/success', [App\Http\Controllers\CarritoController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/checkout/cancel', [App\Http\Controllers\CarritoController::class, 'checkoutCancel'])->name('checkout.cancel');

// Chatbot Gemini
Route::post('/chatbot/ask', [App\Http\Controllers\ChatbotController::class, 'ask'])->name('chatbot.ask');

Route::get('/chatbot', function () {
    return view('chatbot');
})->name('chatbot.demo');

Route::prefix('admin')->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/estadisticas', [\App\Http\Controllers\Admin\DashboardController::class, 'estadisticas'])->name('admin.estadisticas');

    // Rutas para gestionar entrenadores
    Route::get('/entrenadores', [\App\Http\Controllers\Admin\EntrenadorController::class, 'listar'])->name('admin.entrenadores.listar');
    Route::get('/entrenadores/crear', [\App\Http\Controllers\Admin\EntrenadorController::class, 'crear'])->name('admin.entrenadores.crear');
    Route::post('/entrenadores', [\App\Http\Controllers\Admin\EntrenadorController::class, 'almacenar'])->name('admin.entrenadores.almacenar');
    Route::get('/entrenadores/{entrenador}/editar', [\App\Http\Controllers\Admin\EntrenadorController::class, 'editar'])->name('admin.entrenadores.editar');
    Route::put('/entrenadores/{entrenador}', [\App\Http\Controllers\Admin\EntrenadorController::class, 'actualizar'])->name('admin.entrenadores.actualizar');
    Route::delete('/entrenadores/{entrenador}', [\App\Http\Controllers\Admin\EntrenadorController::class, 'eliminar'])->name('admin.entrenadores.eliminar');
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

Route::get('/test-google-calendar', function () {
    $event = Event::create([
        'name' => 'Evento de prueba desde ruta',
        'startDateTime' => now()->addHour(),
        'endDateTime' => now()->addHours(2),
    ]);
    return 'Evento creado en Google Calendar con ID: ' . $event->id;
});

Route::get('/faq', function () {
    return view('faq');
})->name('faq');
