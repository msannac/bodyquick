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
          </a>
          <a href="{{ route('admin.reservas.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Reservas
          </a>
          <a href="{{ route('admin.productos.listar') }}" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
            Listar Productos
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
          <!-- Botón Crear Masiva: solo icono -->
          <button type="button" class="btn btn-warning ml-2 inline-button" style="color: #fff; font-weight:600;" data-toggle="modal" data-target="#modalCrearCitaMasiva" title="Crear Citas Masivas">
            <i class="fas fa-layer-group"></i>
          </button>
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
                  <th class="fecha-col sortable" data-col="0">Fecha <span class="sort-icon"></span></th>
                  <th class="hueco-col sortable" data-col="1">Hueco <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="2">Aforo <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="3">Hora Inicio <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="4">Duración <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="5">Frecuencia <span class="sort-icon"></span></th>
                  <th class="sortable" data-col="6">Actividad <span class="sort-icon"></span></th>
                  <th>Acciones</th>
                </tr>
              </thead>
              <tbody>
                @foreach($citas as $loopIndex => $cita)
                  <tr data-index="{{ $loopIndex }}">
                    <td class="fecha-col">{{ $cita->fecha }}</td>
                    <td class="hueco-col">{{ $cita->hueco }}</td>
                    <td>{{ $cita->aforo }}</td>
                    <td>{{ $cita->hora_inicio }}</td>
                    <td>{{ $cita->duracion }}</td>
                    <td>{{ $cita->frecuencia }}</td>
                    <td>{{ $cita->actividad->nombre ?? 'N/A' }}</td>
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

@include('Admin.Citas.crear_masiva')

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

@push('scripts')
<!-- Se incluye Chart.js solamente para esta vista -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Inicializar datepicker para el filtro de fecha fuera de modales
  $(function(){
    $('#fecha').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true,
      language: 'es',
      orientation: 'bottom',
      templates: {
        leftArrow: '<i class="fa fa-chevron-left"></i>',
        rightArrow: '<i class="fa fa-chevron-right"></i>'
      }
    });
    // Al hacer clic en el icono, abrir el datepicker
    $('#calendar-icon').on('click', function(){
      $('#fecha').datepicker('show');
    });

    // Envío automático del formulario de filtros al cambiar cualquier campo excepto el input de cliente
    $('#filtrosForm input:not(#cliente), #filtrosForm select').on('change', function() {
      $('#filtrosForm').submit();
    });

    // Filtrado AJAX para el input de cliente
    $('#cliente').on('keyup', function(){
      var valor = $(this).val();
      if(valor.length >= 3 || valor.length === 0){
        $.ajax({
          url: $('#filtrosForm').attr('action'),
          method: 'GET',
          data: $('#filtrosForm').serialize(),
          headers: { 'X-Requested-With': 'XMLHttpRequest' },
          success: function(data){
            // Espera que el backend devuelva solo el <tbody>
            $('table tbody').html(data);
          }
        });
      }
    });
  });

  // Ordenación de columnas en la tabla de citas
  $(document).ready(function(){
    var sortState = {};
    var originalRows = [];
    var $tbody = $('table tbody');
    // Guardar el orden original
    $tbody.find('tr').each(function(){
      originalRows.push($(this));
    });

    function resetSortIcons() {
      $('.sort-icon').text('');
    }

    $('.sortable').css('cursor','pointer').on('click', function(){
      var col = $(this).data('col');
      var rows = $tbody.find('tr').toArray();
      var state = sortState[col] || 'none';
      // Alternar estado: none -> asc -> desc -> none
      if(state === 'none') state = 'asc';
      else if(state === 'asc') state = 'desc';
      else state = 'none';
      sortState = {}; sortState[col] = state;
      resetSortIcons();
      if(state === 'asc') $(this).find('.sort-icon').text('▲');
      else if(state === 'desc') $(this).find('.sort-icon').text('▼');
      // Ordenar
      if(state === 'none') {
        // Restaurar orden original
        $tbody.html('');
        originalRows.forEach(function($tr){ $tbody.append($tr); });
      } else {
        rows.sort(function(a, b){
          var aText = $(a).children().eq(col).text().trim();
          var bText = $(b).children().eq(col).text().trim();
          // Si es número, comparar como número
          var aNum = parseFloat(aText.replace(',', '.'));
          var bNum = parseFloat(bText.replace(',', '.'));
          if(!isNaN(aNum) && !isNaN(bNum)) {
            return state === 'asc' ? aNum - bNum : bNum - aNum;
          }
          // Si es fecha (YYYY-MM-DD)
          if(/^\d{4}-\d{2}-\d{2}$/.test(aText) && /^\d{4}-\d{2}-\d{2}$/.test(bText)) {
            return state === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
          }
          // Comparar como texto
          return state === 'asc' ? aText.localeCompare(bText) : bText.localeCompare(aText);
        });
        $tbody.html('');
        rows.forEach(function(tr){ $tbody.append(tr); });
      }
    });
  });
</script>
@endpush