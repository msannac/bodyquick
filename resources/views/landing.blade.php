@extends('layouts.app')

@section('title', 'Landing Page')

@push('styles')
<style>
    html, body {
        height: 100%;
        margin: 0;
    }
    main {
        /* Ocupa el alto disponible restando header y footer (70px cada uno en este ejemplo) */
        height: calc(100vh - 140px);
        padding: 0;
    }
    /* Aseguramos que el carrusel ocupe el 100% del contenedor */
    .carousel,
    .carousel-inner,
    .carousel-item,
    .carousel-item img {
        height: 100%;
    }
    .carousel-item img {
        object-fit: cover;
        width: 100%;
    }
</style>
@endpush

@section('content')
<main class="container-fluid p-0">
    <!-- Carrusel de fondo -->
    <div id="carouselBackground" class="carousel slide" data-ride="carousel" data-interval="3000">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/imagen1-background.jpg') }}" class="d-block w-100" alt="Imagen background 1">
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/imagen2-background.jpg') }}" class="d-block w-100" alt="Imagen background 2">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselBackground" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselBackground" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Siguiente</span>
        </a>
    </div>
</main>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
@endpush