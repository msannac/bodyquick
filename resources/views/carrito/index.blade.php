@extends('layouts.app')

@section('title', 'Mi Carrito')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Mi Carrito</h2>
    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    @if($carrito->isEmpty())
        <div class="alert alert-info">Tu carrito está vacío.</div>
    @else
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>IVA</th>
                <th>Subtotal</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="carrito-contenido">
            @include('carrito._tbody', ['carrito' => $carrito])
        </tbody>
        <tfoot id="carrito-tfoot">
            @include('carrito._tfoot', ['carrito' => $carrito])
        </tfoot>
    </table>
    <a href="#" class="btn btn-secondary abrirModal" data-url="{{ route('cliente.productos.index') }}">Seguir comprando</a>
    <a href="#" class="btn btn-success float-right" id="btnCheckout">Finalizar compra</a>
    @endif
</div>
@endsection
