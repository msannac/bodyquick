<div class="form-wrapper">
  <div class="page-title">
    <i class="fa-solid fa-pen"></i>
    <span>Editar Actividad</span>
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
  <form action="{{ route('admin.actividades.actualizar', $actividad) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="nombre">Nombre</label>
      <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $actividad->nombre }}" required>
    </div>
    <div class="form-group">
      <label for="descripcion">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control">{{ $actividad->descripcion }}</textarea>
    </div>
    <div class="form-group">
      <label for="activo">Activo</label>
      <select name="activo" id="activo" class="form-control" required>
        <option value="1" {{ $actividad->activo ? 'selected' : '' }}>Sí</option>
        <option value="0" {{ !$actividad->activo ? 'selected' : '' }}>No</option>
      </select>
    </div>
    <div class="form-group">
      <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Actualizar Actividad
    </div>
  </form>
</div>