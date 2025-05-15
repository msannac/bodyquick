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
        <div class="row">
          <!-- Columna izquierda: gráficos apilados -->
          <div class="col-md-6">
            <div class="mb-4">
              <h3><i class="fa-solid fa-list"></i> Total de Clientes por semana</h3>
              <canvas id="clientesChart"></canvas>
            </div>
            <div>
              <h3><i class="fa-solid fa-list"></i> Reservas por semana</h3>
              <canvas id="reservasChart"></canvas>
            </div>
          </div>
          <!-- Columna derecha: entrenadores destacados arriba, actividades activas debajo -->
          <div class="col-md-6 d-flex flex-column justify-content-between" style="height: 100%">
            <div class="mb-4">
              <h3><i class="fa-solid fa-users"></i> Entrenadores Destacados</h3>
              <div class="row">
                @foreach($entrenadores as $entrenador)
                  <div class="col-12 mb-3 d-flex align-items-center">
                    <img src="{{ $entrenador->profile_photo_path ? asset('storage/' . $entrenador->profile_photo_path) : asset('images/default-trainer.png') }}" alt="Foto de {{ $entrenador->nombre }}" class="rounded-circle mr-3" style="width:60px;height:60px;object-fit:cover;">
                    <div>
                      <strong>{{ $entrenador->nombre }}</strong><br>
                      <span class="text-muted">{{ $entrenador->especialidad }}</span>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
            <div class="mt-auto" style="margin-top: 48px;">
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