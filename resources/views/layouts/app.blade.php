<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Bodyquick') }} - @yield('title')</title>
    
    <!-- Bootstrap CSS y Font Awesome -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    
    <!-- Incluir jQuery UI CSS y JS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
    <!-- Incluir Bootstrap Datepicker JS y CSS correctamente -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
    
   <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
    @livewireStyles

    <style>
      /* Otros estilos globales muy básicos que requieras */
      header, footer {
          background-color: #000;
           color: #ffffff;
      }
     

    </style>
    @stack('styles')
  </head>
  <body>
    <!-- Header -->
    <header>
      <div class="container d-flex justify-content-between align-items-center">
        <a href="{{ url('/') }}">
          <img src="{{ asset('images/bodyquick-logo-chico.png') }}" alt="Bodyquick Logo" style="height: 50px;">
        </a>
        <div class="d-flex align-items-center">
          @auth
            <span class="mr-3">{{ auth()->user()->name }}</span>
            <!-- Enlace a edición de perfil -->
            <a href="#" class="btn abrirModal" data-url="{{ auth()->user()->is_admin ? route('admin.perfil.editar') : route('cliente.perfil.editar') }}">
              <img src="{{ asset(auth()->user()->profile_photo_path ? 'storage/' . auth()->user()->profile_photo_path : 'images/default-user.png') }}" 
                   alt="Foto de Perfil" 
                   style="width:40px; height:40px; border-radius:50%; object-fit:cover;" 
                   class="mr-3">
            </a>
            <a href="{{ route('logout') }}" class="btn -btn-logout"
            style="background-color: red; border: 1px solid red; color: #ffffff; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-left: 15px;"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Cerrar Sesión
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
              @csrf
            </form>
          @endauth
          @guest
            <!-- Botón para abrir el modal de inicio de sesión -->
            <a href="#" class="btn" style="background-color: red; border: 1px solid red; color: #fff; padding: 8px 15px; border-radius: 5px; text-decoration: none;" data-toggle="modal" data-target="#loginModal">
              Iniciar Sesión
            </a>
          @endguest
        </div>
      </div>
    </header>

    

      <!-- Área de Contenido (se inyecta en cada vista) -->
       <main style="flex: 1;">
    @yield('content')
  </main>
    

    <!-- Footer -->
    <footer class="text-center" style="background-color: #000; color: #fff; padding: 20px 0;">
      <div class="container">
        <div class="row">
          <!-- Primera columna: Texto existente -->
          <div class="col-md-4">
            <p>
              <img src="{{ asset('images/corazon-logo-bodyquick.png') }}" alt="Corazón Bodyquick" style="height:20px; vertical-align:middle;">
              Bodyquick.
            </p>
            <p>
              Somos un Centro de Entrenamiento Personal especialista en electroestimulación situado en el Puerto de Santa María. 
              Consigue resultados inigualables con solo 2 sesiones por semana (perder peso, grasa, tonificar, reducir dolores de espalda, reducir celulitis, mejorar rendimiento deportivo, etc.) 
              ¿Cuál es tu excusa?
            </p>
            <p>
              <a href="{{ route('about') }}" style="color: #fff;">Sobre nosotros</a>
            </p>
          </div>

          <!-- Segunda columna: Imágenes pequeñas -->
          <div class="col-md-4">
            <p>Galería:</p>
            <div class="d-flex flex-column align-items-center">
              <img src="{{ asset('images/imagen1.jpeg') }}" alt="Imagen 1" style="height:50px; margin: 5px 0;">
              <img src="{{ asset('images/imagen2.png') }}" alt="Imagen 2" style="height:50px; margin: 5px 0;">
              <img src="{{ asset('images/imagen3.png') }}" alt="Imagen 3" style="height:50px; margin: 5px 0;">
            </div>
          </div>

          <!-- Tercera columna: Dirección y mapa -->
          <div class="col-md-4">
            <p>
              Estamos en Avda. de la Libertad 32 Local 15-1, Frente Colegio Pinar Hondo. El Puerto de Santa María.
            </p>
            <div>
              <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3169.123456789!2d-6.123456!3d36.123456!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x123456789abcdef!2sUbicación!5e0!3m2!1ses!2ses!4v1234567890" 
                width="100%" 
                height="150" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy">
              </iframe>
            </div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Modal Global para Crear/Editar (vía AJAX) -->
    <div class="modal fade" id="modalAccion" tabindex="-1" role="dialog" aria-labelledby="modalAccionLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document" style="max-width:800px; width: 100%;">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalAccionLabel">Acción</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <!-- Se inyecta contenido vía AJAX -->
          <div class="modal-body"></div>
          <div class="modal-footer">
            
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Confirmación de Eliminación -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Eliminación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ¿Está seguro de eliminar este registro?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-danger" id="btnConfirmDelete">Eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal de Inicio de Sesión -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="loginModalLabel">Iniciar Sesión</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body text-center">
            <!-- Imagen del logo -->
            <img src="{{ asset('images/corazon-logo-bodyquick.png') }}" alt="Corazón Bodyquick" style="height: 50px; margin-bottom: 20px;">

            <!-- Formulario de inicio de sesión -->
            <form method="POST" action="{{ route('login') }}">
              @csrf
              <div class="form-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required autofocus>
              </div>
              <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
              </div>
              <button type="submit" class="btn btn-success">Iniciar Sesión</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts: jQuery, jQuery UI y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
      $(document).ready(function(){
        // Consolidar eventos para evitar duplicación
        $(document).off('click', '.abrirModal').on('click', '.abrirModal', function(e) {
          e.preventDefault();
          var url = $(this).data('url');
          $.get(url, function(data) {
            $('#modalAccion .modal-body').html(data);
            $('#modalAccion').modal('show');
          });
        });

        // SUBMIT AJAX para formularios de perfil admin (y otros que lo requieran)
        $(document).on('submit', 'form[action*="perfil/actualizar"]', function(e) {
          var form = this;
          // Solo AJAX si el formulario está en el modal
          if ($(form).closest('#modalAccion').length > 0) {
            e.preventDefault();
            var formData = new FormData(form);
            var action = $(form).attr('action');
            var method = $(form).attr('method') || 'POST';
            $.ajax({
              url: action,
              type: method,
              data: formData,
              processData: false,
              contentType: false,
              headers: { 'X-Requested-With': 'XMLHttpRequest' },
              success: function(resp) {
                if (resp.success) {
                  $('#modalAccion').modal('hide');
                  // Opcional: recargar la página o solo la foto de perfil
                  location.reload();
                } else if (resp.error) {
                  alert(resp.error);
                }
              },
              error: function(xhr) {
                // Si hay errores de validación, recargar el modal con el HTML devuelto
                if (xhr.status === 422 && xhr.responseText) {
                  $('#modalAccion .modal-body').html(xhr.responseText);
                } else {
                  alert('Error al actualizar el perfil.');
                }
              }
            });
          }
        });

        $(document).on('click', '.btn-custom-eliminar', function(e) {
          e.preventDefault();
          var form = $(this).closest('form');
          $('#confirmDeleteModal').data('form', form).modal('show');
        });

        $('#btnConfirmDelete').on('click', function() {
          var form = $('#confirmDeleteModal').data('form');
          if (form) {
            form.submit();
          }
        });

        // Lógica específica para el modal de edición de reservas
        $(document).on('shown.bs.modal', '#modalAccion', function () {
          const actividadSelect = document.getElementById('actividad');
          const fechaSelect = document.getElementById('fecha');
          const huecoSelect = document.getElementById('hueco');

          if (!actividadSelect || !fechaSelect || !huecoSelect) {
            return;
          }

          // Inicializar el Datepicker
          $(fechaSelect).datepicker({
            format: 'yyyy-mm-dd',
            startDate: new Date(),
            daysOfWeekDisabled: [0, 6],
            autoclose: true,
            todayHighlight: true
          });

          actividadSelect.addEventListener('change', function () {
            const actividadId = this.value;
            fechaSelect.innerHTML = '<option value="">Seleccione un día</option>';
            huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';

            if (actividadId) {
              fetch(`/cliente/reservas/dias-disponibles?actividad_id=${actividadId}`)
                .then(response => response.json())
                .then(data => {
                  $(fechaSelect).datepicker('setDatesDisabled', data.disabledDates);
                });
            }
          });

          $(fechaSelect).on('changeDate', function (e) {
            const actividadId = actividadSelect.value;
            const fecha = e.format('yyyy-mm-dd');
            huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';

            if (actividadId && fecha) {
              fetch(`/cliente/reservas/huecos-disponibles?actividad_id=${actividadId}&fecha=${fecha}`)
                .then(response => response.json())
                .then(data => {
                  data.forEach(hueco => {
                    huecoSelect.innerHTML += `<option value="${hueco.id}">${hueco.hora_inicio} - ${hueco.hora_fin}</option>`;
                  });
                });
            }
          });
        });

        // Lógica para huecos dinámicos en modales de citas admin
        $(document).on('shown.bs.modal', '#modalAccion', function () {
          var actividadInput = $(this).find('#actividad_id');
          var fechaInput = $(this).find('#fecha');
          var huecoSelect = $(this).find('#hueco');
          if (actividadInput.length && fechaInput.length && huecoSelect.length) {
            function cargarHuecosAdmin() {
              var actividadId = actividadInput.val();
              var fecha = fechaInput.val();
              huecoSelect.html('<option value="">Seleccione un hueco</option>');
              if (actividadId && fecha) {
                $.get('/admin/citas/huecos-disponibles', {actividad_id: actividadId, fecha: fecha}, function(data) {
                  if (Array.isArray(data)) {
                    data.forEach(function(hueco) {
                      huecoSelect.append('<option value="'+hueco+'">'+hueco+'</option>');
                    });
                  }
                });
              }
            }
            actividadInput.off('change.huecoAdmin').on('change.huecoAdmin', cargarHuecosAdmin);
            fechaInput.off('change.huecoAdmin').on('change.huecoAdmin', cargarHuecosAdmin);
            // Cargar huecos al abrir el modal si hay valores
            cargarHuecosAdmin();
          }
        });

        // Lógica para inicializar datepicker en modales de edición/creación de citas (admin)
        $(document).on('shown.bs.modal', '#modalAccion', function () {
          // Para formularios de citas admin: busca inputs con clase 'datepicker-cita' o id 'fecha_cita'
          var dateInputs = $(this).find('input.datepicker-cita, input#fecha_cita, input[name="fecha"]');
          if(dateInputs.length > 0) {
            dateInputs.each(function(){
              $(this).datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                daysOfWeekDisabled: [0, 6],
                language: 'es',
                autoclose: true,
                todayHighlight: true
              });
            });
          }
        });

        // Al cerrar el modal, destruir datepicker de citas admin
        $(document).on('hidden.bs.modal', '#modalAccion', function () {
          var dateInputs = $(this).find('input.datepicker-cita, input#fecha_cita, input[name="fecha"]');
          if(dateInputs.length > 0) {
            dateInputs.each(function(){
              try { $(this).datepicker('destroy'); } catch(e){}
            });
          }
        });

        // Reiniciar el modal al cerrarlo
        $(document).on('hidden.bs.modal', '#modalAccion', function () {
          const fechaSelect = document.getElementById('fecha');
          const huecoSelect = document.getElementById('hueco');
          if (fechaSelect) {
            try {
              $(fechaSelect).datepicker('destroy');
            } catch (error) {}
            fechaSelect.innerHTML = '<option value="">Seleccione un día</option>';
          }
          if (huecoSelect) {
            huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';
          }
          $('#actividad').off('change');
          $('#fecha').off('changeDate');
        });
      });
    </script>
    @stack('scripts')
    @livewireScripts

    <!-- Gemini Chatbot Flotante -->
    <button id="chatbot-fab" type="button">
      <i class="fas fa-robot"></i>
    </button>
    <div id="chatbot-window">
      <div id="chatbot-header">
        <span>Gemini Chat</span>
        <button id="chatbot-close" type="button">&times;</button>
      </div>
      <div id="chatbot-messages"></div>
      <form id="chatbot-form" autocomplete="off">
        <input type="text" id="chatbot-message" name="message" placeholder="Escribe tu mensaje..." required autocomplete="off">
        <button type="submit"><i class="fas fa-paper-plane"></i></button>
      </form>
    </div>
    <style>
    #chatbot-fab {
      position: fixed;
      bottom: 24px;
      right: 90px; /* Separado del borde derecho para no tapar otros botones flotantes */
      z-index: 9999;
      background: #27ae60;
      color: #fff;
      border: none;
      border-radius: 50%;
      width: 56px;
      height: 56px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.18);
      font-size: 2rem;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background 0.2s;
    }
    #chatbot-fab:hover {
      background: #219150;
    }
    #chatbot-window {
      position: fixed;
      bottom: 90px;
      right: 90px;
      width: 340px;
      max-width: 98vw;
      background: #fff;
      border-radius: 14px;
      box-shadow: 0 4px 24px rgba(0,0,0,0.18);
      z-index: 10000;
      display: none;
      flex-direction: column;
      overflow: hidden;
    }
    #chatbot-header {
      background: #27ae60;
      color: #fff;
      padding: 10px 16px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-weight: 600;
    }
    #chatbot-header button {
      background: none;
      border: none;
      color: #fff;
      font-size: 1.3rem;
      cursor: pointer;
    }
    #chatbot-messages {
      padding: 12px;
      height: 260px;
      max-height: 260px;
      overflow-y: auto;
      background: #f7f7f7;
      font-size: 0.98rem;
    }
    #chatbot-messages .msg-user {
      text-align: right;
      margin-bottom: 6px;
      color: #333;
    }
    #chatbot-messages .msg-bot {
      text-align: left;
      margin-bottom: 6px;
      color: #27ae60;
    }
    #chatbot-form {
      display: flex;
      border-top: 1px solid #eee;
      background: #fff;
    }
    #chatbot-form input[type="text"] {
      flex: 1;
      border: none;
      padding: 10px;
      font-size: 1rem;
      outline: none;
    }
    #chatbot-form button {
      background: #27ae60;
      color: #fff;
      border: none;
      padding: 0 18px;
      font-size: 1.2rem;
      border-radius: 0 0 14px 0;
      cursor: pointer;
      transition: background 0.2s;
    }
    #chatbot-form button:hover {
      background: #219150;
    }
    @media (max-width: 600px) {
      #chatbot-window {
        right: 80px;
        width: 98vw;
        min-width: 0;
        bottom: 80px;
      }
      #chatbot-fab {
        right: 80px;
        bottom: 16px;
      }
    }
    </style>
    <script>
    (function(){
      const fab = document.getElementById('chatbot-fab');
      const windowEl = document.getElementById('chatbot-window');
      const closeBtn = document.getElementById('chatbot-close');
      const form = document.getElementById('chatbot-form');
      const input = document.getElementById('chatbot-message');
      const messages = document.getElementById('chatbot-messages');

      fab.addEventListener('click', function() {
        windowEl.style.display = 'flex';
        input.focus();
      });
      closeBtn.addEventListener('click', function() {
        windowEl.style.display = 'none';
        messages.innerHTML = '';
        input.value = '';
      });
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = input.value.trim();
        if (!msg) return;
        messages.innerHTML += `<div class='msg-user'>${msg}</div>`;
        input.value = '';
        messages.scrollTop = messages.scrollHeight;
        fetch("{{ route('chatbot.ask') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
          messages.innerHTML += `<div class='msg-bot'>${data.answer}</div>`;
          messages.scrollTop = messages.scrollHeight;
        })
        .catch(() => {
          messages.innerHTML += `<div class='msg-bot'>Error al conectar con Gemini</div>`;
          messages.scrollTop = messages.scrollHeight;
        });
      });
    })();
    </script>
  </body>
</html>
