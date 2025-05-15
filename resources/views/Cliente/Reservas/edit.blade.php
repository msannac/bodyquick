<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Reserva</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <!-- Bootstrap Datepicker -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
</head>
<body>
  <div class="container mt-5">
    <div class="form-wrapper">
      <div class="page-title">
        <i class="fa-regular fa-calendar-days"></i>
        <span>Editar Reserva</span>
      </div>
      <form action="{{ route('cliente.reservas.update', $reserva) }}" method="POST">
        @csrf
        @method('PUT')
        <!-- Seleccionar actividad -->
        <div class="form-group">
          <label for="actividad">Actividad</label>
          <select name="actividad" id="actividad" class="form-control">
            <option value="">Seleccione una actividad</option>
            @foreach($actividades as $actividad)
              <option value="{{ $actividad->id }}" {{ $reserva->cita->actividad_id == $actividad->id ? 'selected' : '' }}>
                {{ $actividad->nombre }}
              </option>
            @endforeach
          </select>
        </div>
        <!-- Seleccionar día -->
        <div class="form-group">
          <label for="fecha">Selecciona el día</label>
          <div class="input-group date" id="datepicker-container">
            <input type="text" name="fecha" id="fecha" class="form-control" value="{{ $reserva->cita->fecha }}" placeholder="Seleccione un día">
            <div class="input-group-append">
              <span class="input-group-text">
                <i class="fa-regular fa-calendar-days"></i>
              </span>
            </div>
          </div>
        </div>
        <!-- Seleccionar hueco -->
        <div class="form-group">
          <label for="hueco">Selecciona el hueco</label>
          <select name="cita_id" id="hueco" class="form-control">
            <option value="">Seleccione un hueco</option>
            <option value="{{ $reserva->cita->id }}" selected>{{ $reserva->cita->hueco }}</option>
          </select>
        </div>
        <!-- Botón -->
        <div class="d-flex">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Guardar Cambios
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>