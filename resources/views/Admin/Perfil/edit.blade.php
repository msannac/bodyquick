<div class="form-wrapper">
  <div class="page-title">
    <i class="fas fa-user-edit icono-label"></i>
    <span>Editar Perfil</span>
  </div>
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
  <form action="{{ route('admin.perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-grid-2cols">
      <div class="form-group custom-file-wrapper-vertical">
        <label for="profile_photo" class="label-foto"><i class="fas fa-image icono-label"></i> Foto</label>
        @if($user->profile_photo_path)
          <div class="mb-2">
            <img src="{{ $user->profile_photo_url }}" alt="Foto de Perfil" style="max-width: 100px; border-radius:50%; margin-top:6px; display:block; margin-left:auto; margin-right:auto;">
          </div>
        @endif
        <input type="file" name="profile_photo" id="profile_photo" class="form-control file-narrow" accept="image/*">
      </div>
      <div>
        <div class="form-group">
           <label for="name"><i class="fas fa-user icono-label"></i> Nombre</label>
           <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required>
        </div>
        <div class="form-group">
           <label for="apellidos"><i class="fas fa-user-tag icono-label"></i> Apellidos</label>
           <input type="text" name="apellidos" id="apellidos" class="form-control" value="{{ $user->apellidos }}">
        </div>
        <div class="form-group">
           <label for="dni"><i class="fas fa-id-card icono-label"></i> DNI</label>
           <input type="text" name="dni" id="dni" class="form-control" value="{{ $user->dni }}">
        </div>
        <div class="form-group">
           <label for="telefono"><i class="fas fa-phone icono-label"></i> Teléfono</label>
           <input type="text" name="telefono" id="telefono" class="form-control" value="{{ $user->telefono }}">
        </div>
        <div class="form-group">
           <label for="email"><i class="fas fa-envelope icono-label"></i> Correo electrónico</label>
           <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" required>
        </div>
        <div class="form-group">
           <label for="password"><i class="fas fa-lock icono-label"></i> Nueva Contraseña </label>
           <input type="password" name="password" id="password" class="form-control">
        </div>
        <div class="form-group">
           <label for="password_confirmation"><i class="fas fa-lock icono-label"></i> Confirmar Contraseña</label>
           <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
        </div>
        <div class="form-group text-right mt-2">
          <button type="submit" class="btn btn-success btn-accion-modal">
            <i class="fas fa-check"></i> Actualizar
          </button>
        </div>
      </div>
    </div>
  </form>
</div>
<style>
.form-grid-2cols {
  display: grid;
  grid-template-columns: 1fr 2fr;
  gap: 6px 24px;
}
.custom-file-wrapper-vertical {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100%;
  min-height: 160px;
}
.label-foto {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-bottom: 4px;
  font-size: 0.98rem;
}
.file-narrow {
  width: 160px !important;
  min-width: 0 !important;
  max-width: 180px !important;
  display: inline-block !important;
  margin: 0 auto 0 auto !important;
  background: #fff !important;
  color: #333 !important;
  font-size: 0.96rem;
  padding: 2px 5px;
  border-radius: 8px;
  border: 1px solid #ccc;
  vertical-align: middle;
  height: 28px;
}
@media (max-width: 991.98px) {
  .form-grid-2cols {
    grid-template-columns: 1fr;
    gap: 4px;
  }
  .custom-file-wrapper-vertical {
    min-height: 90px;
  }
}
.form-wrapper {
  background: rgb(236, 236, 236);
  border-radius: 12px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.10);
  padding: 12px 12px 12px 12px;
  max-width: 700px;
  margin: 0 auto;
  min-width: 260px;
}
@media (min-width: 1600px) {
  .form-wrapper {
    max-width: 1700px;
  }
}
@media (min-width: 1200px) {
  .form-wrapper {
    max-width: 900px;
  }
}
@media (max-width: 1200px) {
  .form-wrapper {
    max-width: 98vw;
  }
}
@media (max-width: 600px) {
  .form-wrapper {
    padding: 4px 2px 4px 2px;
    max-width: 98vw;
  }
}
.page-title {
  display: flex;
  align-items: center;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 4px;
  gap: 6px;
}
.icono-label {
  color: #27ae60;
  margin-right: 3px;
}
.btn-accion-modal {
  border-radius: 8px;
  min-width: 100px;
  padding-left: 0.7rem;
  padding-right: 0.7rem;
  font-size: 0.98rem;
}
.form-group {
  margin-bottom: 2px;
}
.form-group label, .nowrap-label {
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: 0.97rem;
  margin-bottom: 0px;
}
.form-group input, .form-group select, .form-group textarea {
  border-radius: 8px;
  border: 1px solid #ccc;
  width: 100%;
  box-sizing: border-box;
  min-width: 0;
  font-size: 0.96rem;
  padding: 2px 5px;
  height: 28px;
}
</style>
