@extends('layouts.app')
@section('title', 'Pago cancelado')
@section('content')
<div class="container py-5 text-center">
    <h1 class="text-danger"><i class="fas fa-times-circle"></i> Pago cancelado</h1>
    <p>El pago fue cancelado o no se completó. Puedes intentarlo de nuevo desde tu carrito.</p>
    <a href="/carrito" class="btn btn-secondary mt-4">Volver al carrito</a>
</div>
@endsection
