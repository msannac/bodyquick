<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil - Admin</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }
    body {
      display: flex;
      flex-direction: column;
    }
    .main-content {
      flex: 1;
    }
    .form-container { max-width: 800px; margin: 30px auto; }
    /* Estilos comunes para ambos botones */
    .btn-custom-editar, .btn-custom-eliminar {
       display: inline-flex;
       justify-content: center;
       align-items: center;
       width: 140px; /* Ancho fijo */
       height: 50px; /* Altura fija */
       padding: 5px 10px;
       text-decoration: none;
       text-align: center;
       border-radius: 5px;
       margin-right: 10px;
       font-size: 16px;
    }
    .btn-custom-editar {
       border: 1px solid #000;
       background-color: #fff;
       color: #65BC9C;
    }
    .btn-custom-editar:hover {
       background-color: #f8f9fa;
    }
    .btn-custom-eliminar {
       border: 1px solid #000;
       background-color: #fff;
       color: #F15B80;
    }
    .btn-custom-eliminar:hover {
       background-color: #f8f9fa;
    }
    .btn-custom-editar i,
    .btn-custom-eliminar i {
       display: block;
       font-size: 24px;
       margin-bottom: 5px;
    }
    /* Estilos del header */
    header {
      background-color: #f4f4f4;
      padding: 15px 0;
      margin-bottom: 30px;
    }
    header .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header img {
      height: 50px;
    }
    /* Estilos del footer */
    footer {
      background-color: #dcdcdc;
      padding: 15px 0;
      margin-top: 30px;
    }
    footer p {
      margin: 0;
      font-size: 14px;
    }
  </style>
</head>
<body>
  <!-- Header -->
  <header>
    <div class="container">
      <a href="{{ url('/') }}">
        <img src="{{ asset('images/bodyquick-logo-chico.png') }}" alt="Bodyquick Logo">
      </a>
      <div class="d-flex align-items-center">
        @auth
          <span class="mr-3">{{ auth()->user()->name }}</span>
          <!-- Enlace a edición de perfil -->
          <a href="{{ route('admin.perfil.editar') }}">
            <img src="{{ asset(auth()->user()->profile_photo_path ? 'storage/' . auth()->user()->profile_photo_path : 'images/default-user.png') }}"
                 alt="Foto de Perfil" 
                 style="width:40px; height:40px; border-radius:50%; object-fit:cover;" 
                 class="mr-3">
          </a>
          <a href="{{ route('logout') }}" class="btn"
             style="background-color: #65BC9C; border-color: #65BC9C; color: #fff;"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
             Cerrar Sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
          </form>
        @endauth
      </div>
    </div>
  </header>

  <!-- Contenido Principal -->
  <div class="main-content">
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
      <form action="{{ route('admin.perfil.actualizar') }}" method="POST" enctype="multipart/form-data">
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
              <input type="file" name="profile_photo" id="profile_photo" class="form-control mx-auto" style="max-width:200px;">
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
               <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" required>
            </div>
            <div class="form-group">
               <label for="password">Nueva Contraseña <small>(dejar en blanco para no cambiar)</small></label>
               <input type="password" name="password" id="password" class="form-control">
            </div>
            <div class="form-group">
               <label for="password_confirmation">Confirmar Nueva Contraseña</label>
               <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>
            <!-- Botones de acción: alineados con los inputs -->
            <div class="mt-4 text-center">
              <button type="submit" class="btn-custom-editar">
                <i class="fas fa-save"></i> Guardar cambios
              </button>
              <a href="{{ route('admin.dashboard') }}" class="btn-custom-eliminar">
                <i class="fas fa-times"></i> Cancelar
              </a>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container text-center">
      <p>&copy; 2025 Bodyquick. <a href="{{ route('about') }}">Sobre nosotros</a></p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>