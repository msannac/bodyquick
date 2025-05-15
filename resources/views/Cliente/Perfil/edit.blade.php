<div class="container form-container">
  <h1>Editar Perfil</h1>
  @if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
       <ul>
         @foreach($errors->all() as $error)
           <li>{{ $error }}</li>
         @endforeach
       </ul>
    </div>
  @endif
  <form action="{{ route('cliente.perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
      <!-- Columna izquierda: Imagen y selector de archivo -->
      <div class="col-md-4">
        <div class="form-group text-center">
          <label for="profile_photo">Foto de Perfil</label>
          @if($user->profile_photo_path)
            <div class="mb-2">
              <img src="{{ asset('storage/' . $user->profile_photo_path) }}" alt="Foto de Perfil" style="max-width: 100%; border-radius:50%;">
            </div>
          @endif
          <input type="file" name="profile_photo" id="profile_photo" class="form-control mx-auto" style="max-width:150px; font-size:12px; padding:5px;">
        </div>
      </div>
      <!-- Columna derecha: Resto de campos y botones alineados -->
      <div class="col-md-8">
        <div class="form-group">
           <label for="name">Nombre</label>
           <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required>
        </div>
        <div class="form-group">
           <label for="apellidos">Apellidos</label>
           <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $user->apellidos }}">
        </div>
        <div class="form-group">
           <label for="dni">DNI</label>
           <input type="text" name="dni" id="dni" class="form-control" value="{{ $user->dni }}">
        </div>
        <div class="form-group">
           <label for="telefono">Teléfono</label>
           <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $user->telefono }}">
        </div>
        <div class="form-group">
           <label for="email">Correo electrónico</label>
           <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" disabled>
           <small>El correo electrónico no puede modificarse</small>
        </div>
        <div class="form-group">
           <label for="password">Nueva Contraseña <small>(dejar en blanco para mantener la actual)</small></label>
           <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
           <label for="password_confirmation">Confirmar Nueva Contraseña</label>
           <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <!-- Botones de acción: alineados con los inputs -->
        <div class="mt-4 text-center">
          <button type="submit" class="btn btn-success">
            <i class="fas fa-save"></i> Guardar cambios
          </button>
          </a>
        </div>
      </div>
    </div>
  </form>
</div>