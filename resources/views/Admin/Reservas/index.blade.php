@extends('layouts.app')

@section('title','Panel de Control - Listado de Reservas')

@section('content')
  <!-- Contenedor principal -->
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
          <a href="{{ route('admin.reservas.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Reservas
          </a>
        </div>
      </div> 
      <!-- Panel de Contenido -->
      <div class="col-12 col-md-10">
        <div class="container mt-4">
          <div class="d-flex align-items-center">
            <h1 class="mb-0"><i class="fa-solid fa-list"></i> Listado de Reservas</h1>
            <!-- Botón Crear -->
            <a href="{{ route('admin.reservas.crear') }}" 
               class="btn btn-success ml-3 inline-button abrirModal" 
               data-url="{{ route('admin.reservas.crear') }}">
              <i class="fas fa-plus"></i>
            </a>
          </div>
          <!-- Buscador de clientes -->
          <form id="formBuscarClienteReserva" class="mb-3 mt-3" autocomplete="off">
            <div class="row align-items-end">
              <div class="form-group col-sm-12 col-md-4">
                <label for="inputBuscarClienteReserva" class="d-block mb-0">Buscar cliente</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-search"></i></span>
                  </div>
                  <input type="text" name="cliente" id="inputBuscarClienteReserva" class="form-control" placeholder="Nombre del cliente...">
                </div>
              </div>
            </div>
          </form>
          @if(session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
          @endif
          <div class="table-responsive mt-4">
            <table class="table table-bordered table-striped table-reservas-admin">
              <thead class="thead-dark">
                <tr>
                  <th class="sortable" data-col="0">Cliente <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="1">Apellidos <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="2">Actividad <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="3">Fecha <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="4">Hora <span class="sort-icon"></span></th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody id="tablaReservasAdmin">
                @foreach($reservas as $reserva)
                  <tr>
                    <td>{{ $reserva->cliente->name ?? '-' }}</td>
                    <td>{{ $reserva->cliente->apellidos ?? '-' }}</td>
                    <td>{{ $reserva->cita->actividad->nombre ?? '-' }}</td>
                    <td>{{ $reserva->cita->fecha ?? '-' }}</td>
                    <td>{{ $reserva->cita->hora_inicio ?? '-' }}</td>
                    <td>
                      <div class="btn-group-acciones d-flex align-items-center" style="gap: 10px;">
                        <a href="{{ route('admin.reservas.editar', $reserva) }}" 
                           class="btn-custom-editar abrirModal" 
                           data-url="{{ route('admin.reservas.editar', $reserva) }}">
                          <i class="fas fa-edit"></i> Editar
                        </a>
                        <form method="POST" action="{{ route('admin.reservas.eliminar', $reserva) }}" style="display:inline; margin: 0;">
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
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
  $('#inputBuscarClienteReserva').on('keyup', function(){
    var valor = $(this).val();
    if(valor.length >= 3 || valor.length === 0){
      $.ajax({
        url: "{{ route('admin.reservas.listar') }}",
        method: 'GET',
        data: { cliente: valor },
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        success: function(data){
          $('#tablaReservasAdmin').html(data.tbody);
        }
      });
    }
  });
  $('#formBuscarClienteReserva').on('submit', function(e) {
    e.preventDefault();
    var valor = $('#inputBuscarClienteReserva').val();
    $.ajax({
      url: "{{ route('admin.reservas.listar') }}",
      method: 'GET',
      data: { cliente: valor },
      headers: { 'X-Requested-With': 'XMLHttpRequest' },
      success: function(data){
        $('#tablaReservasAdmin').html(data.tbody);
      }
    });
  });

  // Ordenación de columnas en la tabla de reservas admin
  var sortState = {};
  var originalRows = [];
  var $tbody = $('#tablaReservasAdmin');
  $tbody.find('tr').each(function(){
    originalRows.push($(this));
  });
  function resetSortIcons() {
    $('.sort-icon').text('');
  }
  $('.table-reservas-admin .sortable').css('cursor','pointer').on('click', function(){
    var col = $(this).data('col');
    var rows = $tbody.find('tr').toArray();
    var state = sortState[col] || 'none';
    if(state === 'none') state = 'asc';
    else if(state === 'asc') state = 'desc';
    else state = 'none';
    sortState = {}; sortState[col] = state;
    resetSortIcons();
    if(state === 'asc') $(this).find('.sort-icon').text('▲');
    else if(state === 'desc') $(this).find('.sort-icon').text('▼');
    if(state === 'none') {
      $tbody.html('');
      originalRows.forEach(function($tr){ $tbody.append($tr); });
    } else {
      rows.sort(function(a, b){
        var aText = $(a).children().eq(col).text().trim();
        var bText = $(b).children().eq(col).text().trim();
        var aNum = parseFloat(aText.replace(',', '.'));
        var bNum = parseFloat(bText.replace(',', '.'));
        if(!isNaN(aNum) && !isNaN(bNum)) {
          return state === 'asc' ? aNum - bNum : bNum - aNum;
        }
        if(/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(aText) && /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/.test(bText)) {
          return state === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
        }
        return state === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
      });
      $tbody.html('');
      rows.forEach(function(tr){ $tbody.append(tr); });
    }
  });
});
</script>
@endpush

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
  }
  .btn-group-acciones > *:not(:last-child) {
    margin-right: 10px;
  }
  .sortable { cursor: pointer; }
  .sort-icon { font-size: 12px; margin-left: 4px; }
</style>
