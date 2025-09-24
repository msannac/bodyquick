

<?php $__env->startSection('title', 'Dashboard Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar" style="background-color: #F4F4F4; min-height: 100vh; padding: 20px;">
      <div class="title" style="font-size: 24px; color: #000; margin-bottom: 30px; display: flex; align-items: center;">
        <i class="fas fa-user-shield" style="margin-right: 10px; font-size: 28px;"></i> Administrador
      </div>
      <div class="menu">
        <a href="<?php echo e(route('admin.dashboard')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Home
        </a>
        <a href="<?php echo e(route('admin.estadisticas')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Estadísticas
        </a>
        <a href="<?php echo e(route('admin.actividades.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Actividades
        </a>
        <a href="<?php echo e(route('admin.clientes.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Clientes
        </a>
       <a href="<?php echo e(route('admin.citas.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Citas
        </a>
        <a href="<?php echo e(route('admin.entrenadores.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Entrenadores
        </a>
         <a href="<?php echo e(route('admin.reservas.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Reservas
        </a>
        <a href="<?php echo e(route('admin.productos.listar')); ?>" style="display: block; padding: 10px 15px; margin-bottom: 10px; background-color: rgb(254,171,3); color: #fff; text-decoration: none; border-radius: 5px;">
          Listar Productos
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
                
                <?php $__currentLoopData = $entrenadores->slice(0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-4 mb-4 d-flex flex-column align-items-center">
                    <img src="<?php echo e($entrenador->profile_photo_path ? asset('storage/' . $entrenador->profile_photo_path) : asset('images/default-trainer.png')); ?>" alt="Foto de <?php echo e($entrenador->nombre); ?>" class="rounded-circle mb-2" style="width:60px;height:60px;object-fit:cover;">
                    <div class="text-center">
                      <strong><?php echo e($entrenador->nombre); ?></strong><br>
                      <span class="text-muted" style="font-size:13px;"><?php echo e($entrenador->especialidad); ?></span>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php $__currentLoopData = $entrenadores->slice(3, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entrenador): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="col-4 mb-4 d-flex flex-column align-items-center">
                    <img src="<?php echo e($entrenador->profile_photo_path ? asset('storage/' . $entrenador->profile_photo_path) : asset('images/default-trainer.png')); ?>" alt="Foto de <?php echo e($entrenador->nombre); ?>" class="rounded-circle mb-2" style="width:60px;height:60px;object-fit:cover;">
                    <div class="text-center">
                      <strong><?php echo e($entrenador->nombre); ?></strong><br>
                      <span class="text-muted" style="font-size:13px;"><?php echo e($entrenador->especialidad); ?></span>
                    </div>
                  </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </div>
            <div style="height:40px;"></div> <!-- Espacio extra entre sectores -->
            <div class="p-3 shadow-sm rounded bg-white border sector-dashboard" style="height: 50%">
              <h3><i class="fa-solid fa-list"></i> Actividades Activas</h3>
              <ul>
                <?php $__currentLoopData = $actividadesActivas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $actividad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li><?php echo e($actividad->nombre); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            </div>
          </div>
        </div><!-- fin row -->
      </div><!-- fin container mt-4 -->
    </div><!-- fin col-md-10 -->
  </div><!-- fin row -->
</div><!-- fin container-fluid -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- Se incluye Chart.js solamente para esta vista -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // --- Gráfico de Clientes por semana ---
  // Convierte los datos de clientes por semana enviados desde PHP a un objeto JS
  var clientesData = JSON.parse('<?php echo json_encode($clientesPorSemana ?? []); ?>');
  // Obtiene el contexto del canvas donde se dibujará el gráfico de clientes
  var ctxClientes = document.getElementById('clientesChart').getContext('2d');
  // Crea un nuevo gráfico de barras con Chart.js para mostrar clientes por semana
  new Chart(ctxClientes, {
    type: 'bar', // Tipo de gráfico: barras
    data: {
      labels: Object.keys(clientesData), // Semanas como etiquetas del eje X
      datasets: [{
        label: 'Clientes por semana', // Leyenda del dataset
        data: Object.values(clientesData), // Valores de clientes por semana
        // Colores de fondo de las barras, alternando entre varios colores
        backgroundColor: Object.values(clientesData).map((_, index) => {
          const colors = ['rgba(241,91,128,0.5)', 'rgba(54,162,235,0.5)', 'rgba(255,206,86,0.5)', 'rgba(75,192,192,0.5)'];
          return colors[index % colors.length];
        }),
        // Colores de borde de las barras
        borderColor: Object.values(clientesData).map((_, index) => {
          const colors = ['rgba(241,91,128,1)', 'rgba(54,162,235,1)', 'rgba(255,206,86,1)', 'rgba(75,192,192,1)'];
          return colors[index % colors.length];
        }),
        borderWidth: 1 // Grosor del borde de las barras
      }]
    },
    options: {
      responsive: true, // El gráfico se adapta al tamaño del contenedor
      scales: {
        y: {
          beginAtZero: true, // El eje Y empieza en 0
          ticks: {
            stepSize: 1,     // Incremento de 1 en el eje Y
            precision: 0     // Solo números enteros
          }
        }
      }
    }
  });

  // --- Gráfico de Reservas por semana ---
  // Convierte los datos de reservas por semana enviados desde PHP a un objeto JS
  var reservasData = JSON.parse('<?php echo json_encode($reservasPorSemana ?? []); ?>');
  // Obtiene el contexto del canvas donde se dibujará el gráfico de reservas
  var ctxReservas = document.getElementById('reservasChart').getContext('2d');
  // Crea un nuevo gráfico de barras con Chart.js para mostrar reservas por semana
  new Chart(ctxReservas, {
    type: 'bar', // Tipo de gráfico: barras
    data: {
      labels: Object.keys(reservasData), // Semanas como etiquetas del eje X
      datasets: [{
        label: 'Reservas por semana', // Leyenda del dataset
        data: Object.values(reservasData), // Valores de reservas por semana
        // Colores de fondo de las barras, alternando entre varios colores
        backgroundColor: Object.values(reservasData).map((_, index) => {
          const colors = ['rgba(254,171,3,0.5)', 'rgba(75,192,192,0.5)', 'rgba(153,102,255,0.5)', 'rgba(255,159,64,0.5)'];
          return colors[index % colors.length];
        }),
        // Colores de borde de las barras
        borderColor: Object.values(reservasData).map((_, index) => {
          const colors = ['rgba(254,171,3,1)', 'rgba(75,192,192,1)', 'rgba(153,102,255,1)', 'rgba(255,159,64,1)'];
          return colors[index % colors.length];
        }),
        borderWidth: 1 // Grosor del borde de las barras
      }]
    },
    options: {
      responsive: true, // El gráfico se adapta al tamaño del contenedor
      scales: {
        y: {
          beginAtZero: true, // El eje Y empieza en 0
          ticks: {
            stepSize: 1,     // Incremento de 1 en el eje Y
            precision: 0     // Solo números enteros
          }
        }
      }
    }
  });
</script>
<?php $__env->stopPush(); ?>

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
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\bodyquick\resources\views/Admin/estadisticasAdmin.blade.php ENDPATH**/ ?>