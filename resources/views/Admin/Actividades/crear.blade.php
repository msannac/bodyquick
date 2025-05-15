<!-- resources/views/Admin/Actividades/crear.blade.php -->
<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-plus-circle"></i>
    <span>Crear Actividad</span>
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
  <form action="{{ route('admin.actividades.almacenar') }}" method="POST">
    @csrf
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="descripcion">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
    </div>
    <div class="form-group">
      <label for="activo">Activo</label>
      <select name="activo" id="activo" class="form-control" required>
        <option value="1">Sí</option>
        <option value="0">No</option>
      </select>
    </div>
   <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Crear Actividad
    </div>
  </form>
</div>