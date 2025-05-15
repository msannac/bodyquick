<div class="modal-header">
  <h5 class="modal-title" id="modalAccionLabel">Editar Entrenador</h5>
  <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('admin.entrenadores.actualizar', $entrenador) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="row">
      <!-- Columna izquierda: Imagen y selector de archivo -->
      <div class="col-md-4">
        <div class="form-group text-center">
          <label for="profile_photo_path">Foto</label>
          @if($entrenador->profile_photo_path)
            <div class="mb-2">
              <img src="{{ asset('storage/'.$entrenador->profile_photo_path) }}" alt="Foto de Entrenador" style="max-width: 100%; border-radius:50%;">
            </div>
          @endif
          <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control mx-auto" style="max-width:150px; font-size:12px; padding:5px;" accept="image/*">
        </div>
      </div>
      <!-- Columna derecha: Resto de campos y botones alineados -->
      <div class="col-md-8">
        <div class="form-group">
          <label for="nombre">Nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $entrenador->nombre }}" required>
        </div>
        <div class="form-group">
          <label for="apellidos">Apellidos</label>
          <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $entrenador->apellidos }}" required>
        </div>
        <div class="form-group">
          <label for="dni">DNI</label>
          <input type="text" name="dni" id="dni" class="form-control" value="{{ $entrenador->dni }}" required>
        </div>
        <div class="form-group">
          <label for="telefono">Teléfono</label>
          <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $entrenador->telefono }}">
        </div>
        <div class="form-group">
          <label for="especialidad">Especialidad</label>
          <select name="especialidad" id="especialidad" class="form-control" required>
            <option value="entrenamiento funcional" {{ $entrenador->especialidad == 'entrenamiento funcional' ? 'selected' : '' }}>Entrenamiento Funcional</option>
            <option value="electroestimulación" {{ $entrenador->especialidad == 'electroestimulación' ? 'selected' : '' }}>Electroestimulación</option>
            <option value="readaptacion de lesiones" {{ $entrenador->especialidad == 'readaptacion de lesiones' ? 'selected' : '' }}>Readaptación de Lesiones</option>
          </select>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Actualizar Entrenador
        </div>
      </div>
    </div>
  </form>
</div>