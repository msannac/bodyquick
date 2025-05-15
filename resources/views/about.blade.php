<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sobre Nosotros</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }
    .main-content {
      flex: 1;
    }
    /* Header y Footer con el mismo estilo que en el resto de la aplicación */
    header, footer {
      background-color: #dcdcdc;
      padding: 15px 0;
    }
    header .container, footer .container {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    header img {
      height: 50px;
    }
    .logout-btn {
      background-color: #65BC9C;
      border: 1px solid #65BC9C;
      color: #fff;
      padding: 8px 15px;
      border-radius: 5px;
      text-decoration: none;
      margin-left: 15px;
    }
    .form-wrapper {
      border: 1px solid #000;
      padding: 20px;
      border-radius: 5px;
      margin-top: 20px;
    }
    .page-title {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
      font-size: 2rem;
      color: #65BC9C;
    }
    .page-title i {
      margin-right: 10px;
      font-size: 2.5rem;
    }
    footer p {
      text-align: center !important;
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
      <div>
        @auth
          <span>{{ auth()->user()->name }}</span>
          <a href="{{ route('cliente.perfil.editar') }}">
            <img src="{{ asset(auth()->user()->profile_photo_path ? 'storage/' . auth()->user()->profile_photo_path : 'images/default-user.png') }}"
                 alt="Foto de Perfil"
                 style="width:40px; height:40px; border-radius:50%; object-fit:cover; margin-left:10px;">
          </a>
          <a href="{{ route('logout') }}" class="logout-btn"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar Sesión
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
          </form>
        @endauth
        @guest
          <a href="{{ route('login') }}" class="logout-btn">Iniciar Sesión</a>
        @endguest
      </div>
    </div>
  </header>

  <!-- Contenido Principal -->
  <div class="main-content container mt-5">
    <div class="form-wrapper">
      <div class="page-title">
        <i class="fa-solid fa-info-circle"></i>
        <span>Sobre Nosotros</span>
      </div>
      <p>
        Bienvenido a BodyQuick. Somos una empresa dedicada a ofrecer los mejores servicios de salud 
        y bienestar. Nuestro objetivo es ayudar a nuestros clientes a alcanzar sus metas de salud a 
        través de programas personalizados y atención de calidad.
      </p>
      <h2>Datos de Contacto</h2>
      <p>Si tienes alguna pregunta o deseas más información, no dudes en contactarnos:</p>
      <ul>
        <li>Email: contacto@bodyquick.com</li>
        <li>Teléfono: +123 456 7890</li>
        <li>Dirección: Calle Ejemplo 123, Ciudad, País</li>
      </ul>
      <!-- Mapa de ubicación -->
      <div class="mt-4">
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.019668315935!2d-122.40084148468202!3d37.78799497975692!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858064dbce654d%3A0x7e1e7c292c1a24c6!2sCalle%20Ejemplo%20123%2C%20San%20Francisco%2C%20CA!5e0!3m2!1ses!2smx!4v1590000000000!5m2!1ses!2smx" 
          width="100%" 
          height="400" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy">
        </iframe>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container text-center">
      <p>
        &copy; 2016 <img src="{{ asset('images/corazon-logo-bodyquick.png') }}" alt="Corazón Bodyquick" style="height:20px; vertical-align:middle;">
        Bodyquick. <a href="{{ route('about') }}">Sobre nosotros</a>
      </p>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>