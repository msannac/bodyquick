<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-plus-circle"></i>
    <span>Crear Entrenador</span>
  </div>
  @if($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif
  <form action="{{ route('admin.entrenadores.almacenar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="apellidos">Apellidos</label>
      <input type="text" name="apellidos" id="apellidos" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="dni">DNI</label>
      <input type="text" name="dni" id="dni" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="telefono">Teléfono</label>
      <input type="text" name="telefono" id="telefono" class="form-control">
    </div>
    <div class="form-group">
      <label for="especialidad">Especialidad</label>
      <select name="especialidad" id="especialidad" class="form-control" required>
        <option value="entrenamiento funcional">Entrenamiento Funcional</option>
        <option value="electroestimulación">Electroestimulación</option>
        <option value="readaptacion de lesiones">Readaptación de Lesiones</option>
      </select>
    </div>
    <div class="form-group">
      <label for="profile_photo_path">Foto</label>
      <input type="file" name="profile_photo_path" id="profile_photo_path" class="form-control" accept="image/*">
    </div>
    <!-- Botones de acción iguales a los de actividades -->
    <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Crear Entrenador
    </div>
  </form>
</div>

