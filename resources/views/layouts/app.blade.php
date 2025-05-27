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
      html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  body {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
  }
  main {
    flex: 1 0 auto;
  }
  footer {
    flex-shrink: 0;
  }
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
              <img src="{{ auth()->user()->profile_photo_url }}" 
                   alt="{{ auth()->user()->name }}" 
                   style="width:40px; height:40px; border-radius:50%; object-fit:cover;" 
                   class="mr-3">
            </a>
            <a href="#" class="btn" id="btnMarket" style="background-color: #f4b400; border: 1px solid #f4b400; color: #fff; padding: 8px 15px; border-radius: 5px; text-decoration: none; margin-left: 10px;">
              <i class="fas fa-store"></i>
            </a>
            @php
                $carritoCount = 0;
                if(auth()->check()) {
                    $carritoCount = \App\Models\Carrito::where('user_id', auth()->id())->sum('cantidad');
                }
            @endphp
            <a href="#" class="btn btn-outline-success ml-2 position-relative abrirModal" data-url="{{ route('carrito.index') }}">
                <i class="fas fa-shopping-cart"></i>
                <span id="carrito-badge" class="badge badge-danger position-absolute{{ $carritoCount > 0 ? '' : ' d-none' }}" style="top:0; right:0; font-size:0.8rem">{{ $carritoCount > 0 ? $carritoCount : '' }}</span>
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
              Estamos en Avda. de la Libertad 32 Local 13, Frente Colegio Pinar Hondo. El Puerto de Santa María.
            </p>
            <div style="position:relative; min-height:150px;">
              <!-- Google Maps embed oficial -->
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3182.857964964839!2d-6.246302684692383!3d36.59542080000001!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0dd02202fc63e7%3A0x4562de0aeca29e3e!2sBodyQuick!5e0!3m2!1ses-ES!2ses!4v1716220000000!5m2!1ses-ES!2ses"
                width="100%"
                height="150"
                style="border:0; pointer-events:auto; position:relative; z-index:20; background:#fff;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
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

    <!-- Botón FAQ en la barra superior derecha -->
    <button id="btnFaq" class="btn btn-link" style="position: absolute; top: 18px; right: 32px; z-index: 1051; font-size: 1.7rem; color: #27ae60;" data-url="/faq" title="Preguntas Frecuentes">
        <i class="fas fa-question-circle"></i>
    </button>
    <!-- Modal FAQ grande -->
    <div class="modal fade" id="modalFaq" tabindex="-1" role="dialog" aria-labelledby="modalFaqLabel" aria-hidden="true">
      <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalFaqLabel"><i class="fas fa-question-circle text-success"></i> Preguntas Frecuentes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0" id="modalFaqBody">
            <!-- Aquí se cargará el contenido de la FAQ por AJAX -->
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
      $('#btnFaq').on('click', function(e){
        e.preventDefault();
        var url = $(this).data('url');
        $('#modalFaqBody').html('<div class="text-center p-5"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
        $('#modalFaq').modal('show');
        $.get(url, function(data){
          // Mostrar el HTML recibido directamente en el modal
          $('#modalFaqBody').html(data);
        }).fail(function(){
          $('#modalFaqBody').html('<div class="alert alert-danger m-4">No se pudo cargar la información de preguntas frecuentes.</div>');
        });
      });
    });
    </script>
    <script>
      $(document).ready(function(){
        // Abrir cualquier modal AJAX with the class .abrirModal
        $(document).off('click', '.abrirModal').on('click', '.abrirModal', function(e) {
          e.preventDefault();
          var url = $(this).data('url') || $(this).attr('href');
          if (!url) return;
          $.get(url, function(data) {
            $('#modalAccion .modal-body').html(data);
            $('#modalAccion').modal('show');
          }).fail(function(){
            alert('Error al cargar el contenido del modal.');
          });
        });

        // Botón Market para clientes y admin: abre el listado de productos en el modal
        $(document).on('click', '#btnMarket', function(e) {
          e.preventDefault();
          $.get("{{ route('cliente.productos.index') }}", function(data) {
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
          // Destruir todos los datepickers relevantes
          var dateInputs = $(this).find('input.datepicker-cita, input#fecha_cita, input[name="fecha"], #fecha');
          if(dateInputs.length > 0) {
            dateInputs.each(function(){
              try { $(this).datepicker('destroy'); } catch(e){}
            });
          }
          // Resetear selects de fecha y hueco
          const fechaSelect = document.getElementById('fecha');
          const huecoSelect = document.getElementById('hueco');
          if (fechaSelect) {
            fechaSelect.innerHTML = '<option value="">Seleccione un día</option>';
          }
          if (huecoSelect) {
            huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';
          }
          // Limpiar eventos para evitar fugas de memoria
          $('#actividad').off('change');
          $('#fecha').off('changeDate');
        });

        // Lógica específica para el modal de crear reserva admin
        $(document).on('shown.bs.modal', '#modalAccion', function () {
          const userSelect = document.getElementById('user_id');
          const actividadSelect = document.getElementById('actividad');
          const fechaInput = document.getElementById('fecha');
          const huecoSelect = document.getElementById('hueco');

          if (!userSelect || !actividadSelect || !fechaInput || !huecoSelect) return;

          // Reset y deshabilitar campos dependientes
          function resetActividad() {
            actividadSelect.value = '';
            actividadSelect.disabled = true;
            resetFecha();
          }
          function resetFecha() {
            fechaInput.value = '';
            fechaInput.disabled = true;
            if ($(fechaInput).data('datepicker')) {
              try { $(fechaInput).datepicker('destroy'); } catch(e){}
            }
            resetHueco();
          }
          function resetHueco() {
            huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';
            huecoSelect.disabled = true;
          }

          // Al cambiar cliente, habilitar actividad
          userSelect.addEventListener('change', function() {
            resetActividad();
            if (this.value) {
              actividadSelect.disabled = false;
            }
          });

          // Al cambiar actividad, cargar días disponibles y habilitar fecha
          actividadSelect.addEventListener('change', function() {
            resetFecha();
            if (this.value) {
              fechaInput.disabled = false;
              // Cargar días disponibles vía AJAX
              $.get('/admin/reservas/dias-disponibles', {actividad_id: this.value}, function(dias) {
                if ($(fechaInput).data('datepicker')) {
                  try { $(fechaInput).datepicker('destroy'); } catch(e){}
                }
                $(fechaInput).datepicker({
                  format: 'yyyy-mm-dd',
                  startDate: new Date(),
                  autoclose: true,
                  todayHighlight: true,
                  beforeShowDay: function(date) {
                    const ymd = date.toISOString().slice(0,10);
                    return dias.includes(ymd) ? {enabled: true} : false;
                  }
                });
              });
            }
          });

          // Al seleccionar fecha, cargar huecos disponibles
          $(fechaInput).off('changeDate.admin').on('changeDate.admin', function(e) {
            resetHueco();
            const actividadId = actividadSelect.value;
            const fecha = e.format('yyyy-mm-dd');
            if (actividadId && fecha) {
              $.get('/admin/reservas/huecos-disponibles', {actividad_id: actividadId, fecha: fecha}, function(huecos) {
                if (Array.isArray(huecos)) {
                  huecos.forEach(function(hueco) {
                    huecoSelect.append('<option value="'+hueco+'">'+hueco+'</option>');
                  });
                  huecoSelect.disabled = false;
                }
              });
            }
          });

          // Al abrir el modal, resetear todo
          resetActividad();
        });

        // Lógica específica para el modal de editar reserva admin
        $(document).on('shown.bs.modal', '#modalAccion', function () {
          const userSelect = document.getElementById('user_id');
          const actividadSelect = document.getElementById('actividad');
          const fechaInput = document.getElementById('fecha');
          const huecoSelect = document.getElementById('hueco');

          if (!userSelect || !actividadSelect || !fechaInput || !huecoSelect) return;

          // --- EDICIÓN: Preselección y carga dinámica ---
          // Si hay valor en actividad y fecha, cargar días y huecos disponibles
          const actividadInicial = actividadSelect.value;
          const fechaInicial = fechaInput.value;
          const huecoInicial = huecoSelect.value;

          // Reset y deshabilitar campos dependientes
          function resetActividad() {
            actividadSelect.value = '';
            actividadSelect.disabled = true;
            resetFecha();
          }
          function resetFecha() {
            fechaInput.value = '';
            fechaInput.disabled = true;
            if ($(fechaInput).data('datepicker')) {
              try { $(fechaInput).datepicker('destroy'); } catch(e){}
            }
            resetHueco();
          }
          function resetHueco() {
            huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';
            huecoSelect.disabled = true;
          }

          // Al cambiar cliente, habilitar actividad
          userSelect.addEventListener('change', function() {
            resetActividad();
            if (this.value) {
              actividadSelect.disabled = false;
            }
          });

          // Al cambiar actividad, cargar días disponibles y habilitar fecha
          actividadSelect.addEventListener('change', function() {
            resetFecha();
            if (this.value) {
              fechaInput.disabled = false;
              // Cargar días disponibles vía AJAX
              $.get('/admin/reservas/dias-disponibles', {actividad_id: this.value}, function(dias) {
                if ($(fechaInput).data('datepicker')) {
                  try { $(fechaInput).datepicker('destroy'); } catch(e){}
                }
                $(fechaInput).datepicker({
                  format: 'yyyy-mm-dd',
                  startDate: new Date(),
                  autoclose: true,
                  todayHighlight: true,
                  beforeShowDay: function(date) {
                    const ymd = date.toISOString().slice(0,10);
                    return dias.includes(ymd) ? {enabled: true} : false;
                  }
                });
              });
            }
          });

          // Al seleccionar fecha, cargar huecos disponibles
          $(fechaInput).off('changeDate.admin').on('changeDate.admin', function(e) {
            resetHueco();
            const actividadId = actividadSelect.value;
            const fecha = e.format('yyyy-mm-dd');
            if (actividadId && fecha) {
              $.get('/admin/reservas/huecos-disponibles', {actividad_id: actividadId, fecha: fecha}, function(huecos) {
                if (Array.isArray(huecos)) {
                  huecos.forEach(function(hueco) {
                    huecoSelect.append('<option value="'+hueco+'">'+hueco+'</option>');
                  });
                  huecoSelect.disabled = false;
                }
              });
            }
          });

          // --- Inicialización para edición ---
          if (userSelect.value) {
            actividadSelect.disabled = false;
          }
          if (actividadInicial) {
            // Cargar días disponibles y setear el datepicker con la fecha actual
            $.get('/admin/reservas/dias-disponibles', {actividad_id: actividadInicial}, function(dias) {
              if ($(fechaInput).data('datepicker')) {
                try { $(fechaInput).datepicker('destroy'); } catch(e){}
              }
              $(fechaInput).datepicker({
                format: 'yyyy-mm-dd',
                startDate: new Date(),
                autoclose: true,
                todayHighlight: true,
                beforeShowDay: function(date) {
                  const ymd = date.toISOString().slice(0,10);
                  return dias.includes(ymd) ? {enabled: true} : false;
                }
              });
              fechaInput.disabled = false;
              if (fechaInicial) {
                $(fechaInput).datepicker('setDate', fechaInicial);
                // Cargar huecos disponibles para la fecha y actividad actual
                $.get('/admin/reservas/huecos-disponibles', {actividad_id: actividadInicial, fecha: fechaInicial}, function(huecos) {
                  huecoSelect.innerHTML = '<option value="">Seleccione un hueco</option>';
                  if (Array.isArray(huecos)) {
                    huecos.forEach(function(hueco) {
                      const selected = (hueco.id == huecoInicial) ? 'selected' : '';
                      huecoSelect.innerHTML += `<option value="${hueco.id}" ${selected}>${hueco.hora_inicio} - ${hueco.hora_fin}</option>`;
                    });
                    huecoSelect.disabled = false;
                  }
                });
              }
            });
          }
        });

        // Envío AJAX para crear/editar reserva admin
        $(document).on('submit', 'form[action*="admin/reservas"]', function(e) {
          var form = this;
          // Solo AJAX si el formulario está en el modal
          if ($(form).closest('#modalAccion').length > 0) {
            e.preventDefault();
            var formData = new FormData(form);
            var action = $(form).attr('action');
            var method = $(form).find('input[name="_method"]').val() || $(form).attr('method') || 'POST';
            $.ajax({
              url: action,
              type: method,
              data: formData,
              processData: false,
              contentType: false,
              headers: { 'X-Requested-With': 'XMLHttpRequest' },
              success: function(resp) {
                if (resp.success && resp.tbody) {
                  $('#modalAccion').modal('hide');
                  // Recargar solo el tbody de la tabla de reservas
                  var $tbody = $("#tablaReservasAdmin tbody");
                  if ($tbody.length) {
                    $tbody.html(resp.tbody);
                  } else {
                    // Si no hay id, buscar por la tabla principal
                    $("table.table-reservas-admin tbody").html(resp.tbody);
                  }
                  // Opcional: mostrar mensaje de éxito
                  if (resp.message) {
                    $('<div class="alert alert-success mt-3">'+resp.message+'</div>').insertBefore('table.table-reservas-admin').delay(2500).fadeOut(500, function(){$(this).remove();});
                  }
                } else if (resp.error) {
                  alert(resp.error);
                }
              },
              error: function(xhr) {
                if (xhr.status === 422 && xhr.responseText) {
                  $('#modalAccion .modal-body').html(xhr.responseText);
                } else {
                  alert('Error al procesar la reserva.');
                }
              }
            });
          }
        });

        // Actualiza el contador del carrito en el header
        window.actualizarContadorCarrito = function() {
            var badge = $("#carrito-badge");
            $.get("{{ route('carrito.contador') }}", function(data) {
                if (data.count > 0) {
                    badge.text(data.count).show();
                } else {
                    badge.text('').hide();
                }
            });
        }

        // --- GLOBAL: actualizarVistaCarrito ---
        window.actualizarVistaCarrito = function(data) {
          // Actualiza en la página principal
          if ($('#carrito-contenido').length) {
            if (data.html !== undefined) {
              $('#carrito-contenido').html(data.html);
            }
            if (data.tfoot !== undefined) {
              $('#carrito-tfoot').html(data.tfoot);
            }
            if (data.empty !== undefined) {
              if (data.empty) {
                $('.table').hide();
                if ($('#carrito-vacio-msg').length === 0) {
                  $('<div id="carrito-vacio-msg" class="alert alert-info mt-3">Tu carrito está vacío.</div>').insertAfter('.table');
                }
              } else {
                $('.table').show();
                $('#carrito-vacio-msg').remove();
              }
            }
          }
          // Actualiza en el modal si está abierto
          if ($('#modalAccion').hasClass('show')) {
            var modalBody = $('#modalAccion .modal-body');
            if (modalBody.find('#carrito-contenido').length) {
              if (data.html !== undefined) {
                modalBody.find('#carrito-contenido').html(data.html);
              }
              if (data.tfoot !== undefined) {
                modalBody.find('#carrito-tfoot').html(data.tfoot);
              }
              if (data.empty !== undefined) {
                if (data.empty) {
                  modalBody.find('.table').hide();
                  if (modalBody.find('#carrito-vacio-msg').length === 0) {
                    $('<div id="carrito-vacio-msg" class="alert alert-info mt-3">Tu carrito está vacío.</div>').insertAfter(modalBody.find('.table'));
                  }
                } else {
                  modalBody.find('.table').show();
                  modalBody.find('#carrito-vacio-msg').remove();
                }
              }
            }
          }
        }
        // Llamar a la función al cargar la página para establecer el contador inicial
        window.actualizarContadorCarrito();

        // Ejemplo de uso: después de agregar un producto al carrito via AJAX, llamar a la función para actualizar el contador
        $(document).on('submit', 'form[id^="form-agregar-carrito-"]', function(e) {
          e.preventDefault();
          var form = $(this);
          var url = form.attr('action');
          var method = form.attr('method') || 'POST';
          var formData = new FormData(this);
          $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(resp) {
              if (resp.success) {
                // Actualizar contador del carrito
                window.actualizarContadorCarrito();
                // Opcional: mostrar mensaje de éxito o actualizar vista del carrito
                $('<div class="alert alert-success mt-3">Producto agregado al carrito.</div>').insertBefore('table.table-reservas-admin').delay(2500).fadeOut(500, function(){$(this).remove();});
              } else if (resp.error) {
                alert(resp.error);
              }
            },
            error: function(xhr) {
              alert('Error al agregar el producto al carrito.');
            }
          });
        });
      });
    </script>
    <script>
// LÓGICA GLOBAL: Añadir al carrito (funciona en página y en modal)
$(document).on('click', '.add-to-cart-btn', function(e) {
  e.preventDefault();
  const btn = this;
  const productoId = $(btn).data('producto-id');
  fetch('/carrito/agregar', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    body: JSON.stringify({ producto_id: productoId, cantidad: 1 })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (typeof window.actualizarContadorCarrito === 'function') {
        window.actualizarContadorCarrito();
      }
      // Feedback visual en el botón
      btn.classList.add('btn-success');
      btn.classList.remove('btn-primary');
      btn.innerHTML = '<i class="fas fa-check"></i> Añadido';
      setTimeout(() => {
        btn.classList.remove('btn-success');
        btn.classList.add('btn-primary');
        btn.innerHTML = '<i class="fas fa-cart-plus"></i> Añadir al carrito';
      }, 1200);
      // --- NUEVO: actualizar carrito en la vista si está presente ---
      window.actualizarVistaCarrito(data);
    } else {
      alert(data.message || 'Error al añadir al carrito');
    }
  })
  .catch(() => alert('Error al añadir al carrito'));
});
</script>
<script>
// LÓGICA GLOBAL: Actualizar cantidad en carrito (funciona en página y modal)
$(document).on('change', '.input-cantidad-carrito', function(e) {
  e.preventDefault();
  const input = this;
  const id = $(input).data('carrito-id');
  const cantidad = parseInt($(input).val(), 10);
  if (!id || isNaN(cantidad) || cantidad < 1) return;
  fetch('/carrito/modificar/' + id, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    body: JSON.stringify({ cantidad })
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (typeof window.actualizarContadorCarrito === 'function') {
        window.actualizarContadorCarrito();
      }
      // Feedback visual
      $(input).addClass('is-valid');
      setTimeout(() => $(input).removeClass('is-valid'), 1000);
      actualizarVistaCarrito(data);
    } else {
      alert(data.message || 'Error al actualizar el carrito');
    }
  })
  .catch(() => alert('Error al actualizar el carrito'));
});

// LÓGICA GLOBAL: Eliminar producto del carrito (con modal de confirmación)
let carritoIdAEliminar = null;
let btnEliminarCarrito = null;
$(document).on('click', '.btn-eliminar-carrito', function(e) {
  e.preventDefault();
  btnEliminarCarrito = this;
  carritoIdAEliminar = $(btnEliminarCarrito).data('carrito-id');
  const nombre = $(btnEliminarCarrito).data('nombre') || '';
  // Personalizar mensaje si se desea
  $('#confirmDeleteModal .modal-body').html('¿Está seguro de eliminar <b>' + nombre + '</b> del carrito?');
  $('#confirmDeleteModal').modal('show');
});
$('#btnConfirmDelete').off('click.carrito').on('click.carrito', function() {
  if (!carritoIdAEliminar) return;
  var url = '/carrito/eliminar/' + carritoIdAEliminar;
  fetch(url, {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
      'Accept': 'application/json'
    },
    body: JSON.stringify({}) // <-- Importante para Laravel
  })
  .then(res => res.json())
  .then(data => {
    if (data.success) {
      if (typeof window.actualizarContadorCarrito === 'function') {
        window.actualizarContadorCarrito();
      }
      actualizarVistaCarrito(data);
      $('#confirmDeleteModal').modal('hide');
    } else {
      alert(data.message || 'Error al eliminar del carrito');
    }
  })
  .catch(() => {
    alert('Error al eliminar del carrito');
  });
  carritoIdAEliminar = null;
  btnEliminarCarrito = null;
});
</script>
  @yield('scripts')
  @stack('scripts')
  </body>
</html>
