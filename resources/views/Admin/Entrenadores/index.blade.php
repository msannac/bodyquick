@extends('layouts.app')

@section('title','Panel de Control - Listado de Entrenadores')

@section('content')
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
      <div class="col-md-2 sidebar" style="background-color: #F4F4F4; min-height: 100vh; padding: 20px;">
        <div class="title" style="font-size: 24px; color: #000; margin-bottom: 30px; display: flex; align-items: center;">
          <i class="fas fa-user-shield" style="margin-right: 10px; font-size: 28px;"></i> Administrador
        </div>
        <div class="menu">
          <a href="{{ route('admin.dashboard') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Home
          </a>
          <a href="{{ route('admin.estadisticas') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Estadísticas
          </a>
          <a href="{{ route('admin.actividades.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Actividades
          </a>
          <a href="{{ route('admin.clientes.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Clientes
          </a>
          <a href="{{ route('admin.citas.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Citas
          </a>
          <a href="{{ route('admin.entrenadores.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Entrenadores
          </a>
          </a>
          <a href="{{ route('admin.reservas.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Reservas
          </a>
        </div>
      </div> 
      <!-- Panel de Contenido -->
      <div class="col-12 col-md-10">
        <div class="container mt-4 position-relative">
          <div class="d-flex align-items-center">
            <h1 class="mb-0"><i class="fa-solid fa-list"></i> Listado de Entrenadores</h1>
            <!-- Botón Crear para abrir el modal -->
            <a href="{{ route('admin.entrenadores.crear') }}" 
               class="btn btn-success ml-3 inline-button abrirModal" 
               data-url="{{ route('admin.entrenadores.crear') }}">
              <i class="fas fa-plus"></i>
            </a>
          </div>
          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif
          <!-- Cards de entrenadores -->
          <div class="row mt-4">
            @foreach($entrenadores as $entrenador)
              <div class="col-12 col-md-4 mb-4">
                <div class="card small-card">
                  <div class="circle-img-wrapper">
                    @if($entrenador->profile_photo_path)
                      <img src="{{ asset('storage/' . $entrenador->profile_photo_path) }}" class="card-img-top" alt="{{ $entrenador->nombre }}">
                    @else
                      <img src="{{ asset('images/default-user.png') }}" class="card-img-top" alt="{{ $entrenador->nombre }}">
                    @endif
                  </div>
                  <div class="card-body text-center p-2">
                    <h6 class="card-title mb-1">{{ $entrenador->nombre }} {{ $entrenador->apellidos }}</h6>
                    <p class="card-text mb-2">{{ ucfirst($entrenador->especialidad) }}</p>
                    <div class="btn-group-acciones">
                      <a href="{{ route('admin.entrenadores.editar', $entrenador) }}" 
                         class="btn-custom-editar abrirModal" data-url="{{ route('admin.entrenadores.editar', $entrenador) }}">
                        <i class="fas fa-edit"></i>
                      </a>
                      <form method="POST" action="{{ route('admin.entrenadores.eliminar', $entrenador) }}" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn-custom-eliminar btn-eliminar">
                          <i class="fas fa-trash-alt"></i>
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach  
          </div>
          <!-- Fin de las cards -->
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
@endpush

<style>
  .card {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border: none;
  }
  .card-title {
    margin-bottom: 0.5rem;
    font-weight: bold;
  }
  /* Botón flotante/inline para crear */
  .inline-button {
    background-color: #00a65a !important;
    border: 1px solid #00a65a !important;
    color: #fff !important;
    padding: 10px 15px;
    font-size: 24px;
    border-radius: 50%;
    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
    transform: translateY(-5%);
  }
  @media (max-width: 992px) {
    .inline-button {
      font-size: 20px;
      padding: 8px 12px;
      transform: translateY(0);
    }
  }
  @media (max-width: 768px) {
    .inline-button {
      font-size: 16px;
      padding: 6px 10px;
      position: fixed;
      bottom: 20px;
      right: 20px;
      transform: none;
      z-index: 1000;
    }
  }
  
  
  
  @media (max-width: 768px) {
    .table-responsive {
      overflow-x: auto;
    }
  }
  
  /* Tarjetas más pequeñas */
  .small-card {
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    border: none;
    border-radius: 15px;
    overflow: hidden;
    padding-top: 8px;
    padding-bottom: 8px;
    min-height: 270px;
    background: rgb(236, 236, 236);
  }
  .card-title {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
  }
  .card-text {
    font-size: 0.9rem;
  }
  .card-img-top {
    width: 94px;
    height: 94px;
    object-fit: cover;
    background-color: #fff;
    border-radius: 50%;
    margin: 0;
    display: block;
    border: none;
    box-shadow: none;
    position: static;
  }
  .circle-img-wrapper {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: #fff;
    margin: 12px auto 8px auto;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    border: 2px solid #e0e0e0;
    position: relative;
    z-index: 1;
    overflow: hidden;
  }
  
  /* Estilos para los botones de editar y eliminar */
  .btn-custom-editar,
  .btn-custom-eliminar {
    width: 45px !important;
    height: 45px !important;
    padding: 0 !important;
    font-size: 1rem !important;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
  }
  
  .btn-custom-editar {
    background-color: #00a65a !important;
    color: #fff !important;
    border: 1px solid #00a65a !important;
  }
  
  .btn-custom-eliminar {
    background-color: #d11149 !important;
    color: #fff !important;
    border: 1px solid #d11149 !important;
    margin-left: 10px;
  }
  
  .btn-group-acciones {
    display: flex;
    justify-content: center;
  }
</style>
