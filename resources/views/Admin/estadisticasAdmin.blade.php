@extends('layouts.app')

@section('title', 'Dashboard Admin')

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

    <!-- Contenido del Dashboard -->
    <div class="col-md-10">
      <div class="container mt-4">
        <div class="row dashboard-row-equal">
          <!-- Columna izquierda: gráficos apilados -->
          <div class="col-md-6">
            <div class="mb-4 p-3 shadow-sm rounded bg-white border sector-dashboard">
              <h3><i class="fa-solid fa-list"></i> Total de Clientes por semana</h3>
              <canvas id="clientesChart"></canvas>
            </div>
            <div class="p-3 shadow-sm rounded bg-white border sector-dashboard">
              <h3><i class="fa-solid fa-list"></i> Reservas por semana</h3>
              <canvas id="reservasChart"></canvas>
            </div>
          </div>
          <!-- Columna derecha: entrenadores destacados arriba, actividades activas debajo -->
          <div class="col-md-6">
            <div class="mb-4 p-3 shadow-sm rounded bg-white border sector-dashboard">
              <h3><i class="fa-solid fa-users"></i> Entrenadores Destacados</h3>
              <div class="row">
                {{-- Primeros 3 entrenadores en la primera fila --}}
                @foreach($entrenadores->slice(0, 3) as $entrenador)
                  <div class="col-4 mb-4 d-flex flex-column align-items-center">
                    <img src="{{ $entrenador->profile_photo_path ? asset('storage/' . $entrenador->profile_photo_path) : asset('images/default-trainer.png') }}" alt="Foto de {{ $entrenador->nombre }}" class="rounded-circle mb-2" style="width:60px;height:60px;object-fit:cover;">
                    <div class="text-center">
                      <strong>{{ $entrenador->nombre }}</strong><br>
                      <span class="text-muted" style="font-size:13px;">{{ $entrenador->especialidad }}</span>
                    </div>
                  </div>
                @endforeach
                {{-- Siguientes 3 entrenadores en la segunda fila --}}
                @foreach($entrenadores->slice(3, 3) as $entrenador)
                  <div class="col-4 mb-4 d-flex flex-column align-items-center">
                    <img src="{{ $entrenador->profile_photo_path ? asset('storage/' . $entrenador->profile_photo_path) : asset('images/default-trainer.png') }}" alt="Foto de {{ $entrenador->nombre }}" class="rounded-circle mb-2" style="width:60px;height:60px;object-fit:cover;">
                    <div class="text-center">
                      <strong>{{ $entrenador->nombre }}</strong><br>
                      <span class="text-muted" style="font-size:13px;">{{ $entrenador->especialidad }}</span>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div style="height:40px;"></div> <!-- Espacio extra entre sectores -->
            <div class="p-3 shadow-sm rounded bg-white border sector-dashboard" style="height: 50%">
              <h3><i class="fa-solid fa-list"></i> Actividades Activas</h3>
              <ul>
                @foreach($actividadesActivas as $actividad)
                  <li>{{ $actividad->nombre }}</li>
                @endforeach
              </ul>
            </div>
          </div>
        </div><!-- fin row -->
      </div><!-- fin container mt-4 -->
    </div><!-- fin col-md-10 -->
  </div><!-- fin row -->
</div><!-- fin container-fluid -->
@endsection

@push('scripts')
<!-- Se incluye Chart.js solamente para esta vista -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Gráfico de Clientes por semana
  var clientesData = JSON.parse('{!! json_encode($clientesPorSemana ?? []) !!}');
  var ctxClientes = document.getElementById('clientesChart').getContext('2d');
  new Chart(ctxClientes, {
    type: 'bar',
    data: {
      labels: Object.keys(clientesData),
      datasets: [{
        label: 'Clientes por semana',
        data: Object.values(clientesData),
        backgroundColor: Object.values(clientesData).map((_, index) => {
          const colors = ['rgba(241,91,128,0.5)', 'rgba(54,162,235,0.5)', 'rgba(255,206,86,0.5)', 'rgba(75,192,192,0.5)'];
          return colors[index % colors.length];
        }),
        borderColor: Object.values(clientesData).map((_, index) => {
          const colors = ['rgba(241,91,128,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)'];
          return colors[index % colors.length];
        }),
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            precision: 0
          }
        }
      }
    }
  });

  // Gráfico de Reservas por semana
  var reservasData = JSON.parse('{!! json_encode($reservasPorSemana ?? []) !!}');
  var ctxReservas = document.getElementById('reservasChart').getContext('2d');
  new Chart(ctxReservas, {
    type: 'bar',
    data: {
      labels: Object.keys(reservasData),
      datasets: [{
        label: 'Reservas por semana',
        data: Object.values(reservasData),
        backgroundColor: Object.values(reservasData).map((_, index) => {
          const colors = ['rgba(254,171,3,0.5)', 'rgba(75,192,192,0.5)', 'rgba(153,102,255,0.5)', 'rgba(255,159,64,0.5)'];
          return colors[index % colors.length];
        }),
        borderColor: Object.values(reservasData).map((_, index) => {
          const colors = ['rgba(254,171,3,1)', 'rgba(75,192,192,1)', 'rgba(153,102,255,1)', 'rgba(255,159,64,1)'];
          return colors[index % colors.length];
        }),
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            stepSize: 1,
            precision: 0
          }
        }
      }
    }
  });
</script>
@endpush

<style>
  .sector-dashboard {
    min-height: 260px;
    height: auto;
    margin-bottom: 24px;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
  }
  .dashboard-row-equal > [class^='col-'] > .sector-dashboard {
    min-height: 260px;
    height: auto;
  }
  @media (min-width: 768px) {
    .dashboard-row-equal {
      display: flex;
    }
    .dashboard-row-equal > .col-md-6 {
      display: flex;
      flex-direction: column;
      justify-content: stretch;
    }
    .dashboard-row-equal > .col-md-6 > .sector-dashboard {
      flex: 1 1 0;
      min-height: 320px;
      height: 100%;
      margin-bottom: 32px;
    }
    .dashboard-row-equal > .col-md-6 > .sector-dashboard:last-child {
      margin-bottom: 0;
    }
  }
  @media (max-width: 767.98px) {
    .dashboard-row-equal {
      display: block;
    }
    .dashboard-row-equal > .col-md-6 {
      display: block;
      width: 100%;
      margin-bottom: 24px;
    }
    .sector-dashboard {
      min-height: 180px;
      margin-bottom: 20px;
    }
  }
</style>