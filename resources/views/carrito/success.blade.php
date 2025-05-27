@extends('layouts.app')
@section('title', 'Pago Exitoso')
@section('content')
<div class="container py-5 text-center">
    <h1 class="text-success"><i class="fas fa-check-circle"></i> ¡Pago realizado con éxito!</h1>
    <p>Gracias por tu compra. En breve recibirás un email con tu factura.</p>
    <a href="/cliente/reservas" class="btn btn-primary mt-4">Ir a mis reservas</a>
</div>
@endsection
