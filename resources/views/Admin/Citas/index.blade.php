@extends('layouts.app')

@section('title', 'Panel de Control - Listado de Citas')

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
        </div>
      </div> 

    <!-- Panel de Contenido -->
    <div class="col-md-10">
      <div class="container mt-4 position-relative">
        <!-- Encabezado -->
        <div class="d-flex align-items-center">
          <h1 class="mb-0"><i class="fa-solid fa-list"></i> Listado de Citas</h1>
          <!-- Botón Crear: se abre el modal vía AJAX -->
          <a href="{{ route('admin.citas.crear') }}" 
             class="btn btn-success ml-3 inline-button abrirModal" 
             data-url="{{ route('admin.citas.crear') }}">
            <i class="fas fa-plus"></i>
          </a>
        </div>
        
        <!-- Filtros -->
        <form action="{{ route('admin.citas.listar') }}" method="GET" id="filtrosForm" class="mb-4">
          <div class="row align-items-end">
            <!-- Filtro Fecha -->
            <div class="form-group col-sm-12 col-md-3">
              <i class="fa-solid fa-calendar-days"></i>
              <label for="fecha" class="d-block mb-0">Fecha</label>
              <div class="input-group">
                <input type="text" name="fecha" id="fecha" class="form-control" required value="{{ request('fecha', $fecha) }}">
                <div class="input-group-append">
                  <span class="input-group-text" id="calendar-icon"><i class="fa fa-calendar"></i></span>
                </div>
              </div>
            </div>
            <!-- Filtro Actividad -->
            <div class="form-group col-sm-12 col-md-3">
              <i class="fa-solid fa-dumbbell"></i>
              <label for="actividad_id" class="d-block mb-0">Actividad</label>
              <select name="actividad_id" id="actividad_id" class="form-control">
                <option value="">Todas</option>
                @foreach($actividades as $actividad)
                  <option value="{{ $actividad->id }}" {{ ($actividad->id == request('actividad_id', $actividad_id)) ? 'selected' : '' }}>
                    {{ $actividad->nombre }}
                  </option>
                @endforeach
              </select>
            </div>
            <!-- Filtro Cliente -->
            <div class="form-group col-sm-12 col-md-3">
              <label for="cliente" class="d-block mb-0">Cliente</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="fa fa-search"></i></span>
                </div>
                <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Buscar cliente..." value="{{ request('cliente') }}">
              </div>
            </div>
          </div>
        </form>
        
        <!-- Tabla de Citas -->
        @if($citas->isEmpty())
          <p>No hay citas para el día seleccionado.</p>
        @else
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <tr>
                  <th class="fecha-col">Fecha</th>
                  <th class="hueco-col">Hueco</th>
                  <th>Aforo</th>
                  <th>Hora Inicio</th>
                  <th>Duración</th>
                  <th>Frecuencia</th>
                  <th>Actividad</th>
                  <th>Cliente</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($citas as $cita)
                  <tr>
                    <td class="fecha-col">{{ $cita->fecha }}</td>
                    <td class="hueco-col">{{ $cita->hueco }}</td>
                    <td>{{ $cita->aforo }}</td>
                    <td>{{ $cita->hora_inicio }}</td>
                    <td>{{ $cita->duracion }}</td>
                    <td>{{ $cita->frecuencia }}</td>
                    <td>{{ $cita->actividad->nombre ?? 'N/A' }}</td>
                    <td>{{ $cita->cliente->name ?? 'N/A' }}</td>
                    <td>
                      <div class="btn-group-acciones">
                        <!-- Botón Editar: se abre el modal vía AJAX -->
                        <a href="{{ route('admin.citas.editar', $cita) }}" 
                           class="btn-custom-editar abrirModal" 
                           data-url="{{ route('admin.citas.editar', $cita) }}">
                          <i class="fas fa-edit"></i> Editar
                        </a>
                        <!-- Botón Eliminar: se abre el modal de confirmación -->
                        <form method="POST" action="{{ route('admin.citas.eliminar', $cita) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn-custom-eliminar btn-eliminar">
                              <i class="fas fa-trash-alt"></i> Eliminar
                            </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-4">
            {{ $citas->links() }}
          </div>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection

<!-- Estilos personalizados -->
<style>
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
      z-index: 1000;
      transform: none;
    }
  }
  .btn-custom-editar {
    background-color: #ffffff;
    color: #00a65a;
    border: 1px solid #00a65a;
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }
  .btn-custom-eliminar {
    background-color: #ffffff;
    color: #d11149;
    border: 1px solid #d11149;
    padding: 5px 10px;
    border-radius: 5px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }
  .btn-group-acciones {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
  }
  .btn-group-acciones form {
    margin: 0;
  }
  .btn-custom-editar,
  .btn-custom-eliminar {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 45px;
    min-height: 38px;
    padding: 0 10px;
    font-size: 1rem;
    border-radius: 5px;
  }
  @media (max-width: 768px) {
    .table-responsive { overflow-x: auto; }
  }
</style>