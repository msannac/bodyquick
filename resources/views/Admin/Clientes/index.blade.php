@extends('layouts.app')

@section('title','Panel de Control - Listado de Clientes')

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
      <div class="col-12 col-md-10">
        <div class="container mt-4 position-relative">
          <div class="d-flex align-items-center">
            <h1 class="mb-0"><i class="fa-solid fa-list"></i> Listado de Clientes</h1>
            <!-- Botón Crear modificado para abrir el modal -->
            <a href="{{ route('admin.clientes.crear') }}" 
               class="btn btn-success ml-3 inline-button abrirModal" 
               data-url="{{ route('admin.clientes.crear') }}">
              <i class="fas fa-plus"></i>
            </a>
          </div>
          <!-- Buscador de clientes -->
          <form action="{{ route('admin.clientes.listar') }}" method="GET" id="buscadorClientesForm" class="mb-3 mt-3">
            <div class="row align-items-end">
              <div class="form-group col-sm-12 col-md-4">
                <label for="cliente" class="d-block mb-0">Buscar cliente</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                  </div>
                  <input type="text" name="cliente" id="cliente" class="form-control" placeholder="Nombre del cliente..." value="{{ request('cliente') }}">
                </div>
              </div>
            </div>
          </form>
          <script>
            $(document).ready(function(){
              $('#cliente').on('keyup', function(){
                var valor = $(this).val();
                if(valor.length >= 3 || valor.length === 0){
                  $.ajax({
                    url: $('#buscadorClientesForm').attr('action'),
                    method: 'GET',
                    data: { cliente: valor },
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(data){
                      // Espera que el backend devuelva solo el <tbody>
                      $('table tbody').html(data);
                    }
                  });
                }
              });
            });
          </script>
          @if(session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
          @endif
          <!-- Contenedor de la tabla con scroll horizontal en móviles -->
          <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped">
              <thead class="thead-dark">
                <tr>
                  <th>Nombre</th>
                  <th>Apellidos</th>
                  <th>Email</th>
                  <th>DNI</th>
                  <th>Teléfono</th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->name }}</td>
                    <td>{{ $cliente->apellidos }}</td>
                    <td>{{ $cliente->email }}</td>
                    <td>{{ $cliente->dni }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>
                        <div class="btn-group-acciones">
                            <a href="{{ route('admin.clientes.editar', $cliente) }}" class="btn-custom-editar abrirModal" data-url="{{ route('admin.clientes.editar', $cliente) }}">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form method="POST" action="{{ route('admin.clientes.eliminar', $cliente) }}" style="display:inline;">
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
          <!-- Fin de la tabla -->
        </div>
      </div>
    </div>
  </div>
@endsection

<!-- Estilos personalizados para que el comportamiento de los botones sea igual al de Actividades -->
<style>
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
  
  .btn-custom-editar {
    background-color: #ffffff;
    color: #00a65a;
    border: 1px solid #00a65a;
    padding: 5px 10px;
    text-decoration: none;
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
    text-decoration: none;
    border-radius: 5px;
    vertical-align: middle;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
  }
  .btn-group-acciones form {
    margin: 0;
  }
  .btn-group-acciones {
    display: flex;
    align-items: center;
  }
  .btn-group-acciones > *:not(:last-child) {
    margin-right: 10px;
  }
  
  @media (max-width: 768px) {
    .table-responsive {
      overflow-x: auto;
    }
  }
</style>