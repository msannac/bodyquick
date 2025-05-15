<?php

use Laravel\Fortify\Features;

return [

    /*
    |--------------------------------------------------------------------------
    | Guardia de Fortify
    |--------------------------------------------------------------------------
    |
    | Aquí se especifica qué "guard" se utilizará para autenticar a los usuarios.
    | Este valor debe corresponder a una de las guardias definidas en el archivo
    | de configuración "auth".
    |
    */
    'guard' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Broker de Contraseñas de Fortify
    |--------------------------------------------------------------------------
    |
    | Aquí se define qué broker de contraseñas se utilizará cuando un usuario
    | reinicie su contraseña. Este valor debe coincidir con uno de los brokers
    | definidos en tu archivo de configuración "auth".
    |
    */
    'passwords' => 'users',

    /*
    |--------------------------------------------------------------------------
    | Nombre de Usuario / Correo Electrónico
    |--------------------------------------------------------------------------
    |
    | Este valor define cuál atributo del modelo se considerará el "nombre de usuario"
    | de la aplicación. Por lo general, se utiliza el correo electrónico, pero puedes
    | cambiar este valor si lo deseas.
    |
    | Fortify espera que los formularios de olvido o reseteo de contraseña tengan
    | un campo llamado 'email' a menos que se especifique lo contrario.
    |
    */
    'username' => 'email',

    'email' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Nombres de Usuario en minúsculas
    |--------------------------------------------------------------------------
    |
    | Esta opción define si se deben pasar los nombres de usuario a minúsculas
    | antes de guardarlos en la base de datos, ya que algunos sistemas son sensibles
    | a mayúsculas/minúsculas.
    |
    */
    'lowercase_usernames' => true,

    /*
    |--------------------------------------------------------------------------
    | Ruta de Inicio
    |--------------------------------------------------------------------------
    |
    | Aquí se configura la ruta a la que serán redirigidos los usuarios luego de
    | autenticarse o después de un reinicio de contraseña exitoso.
    |
    */
    'home' => '/dashboard',

    /*
    |--------------------------------------------------------------------------
    | Prefijo / Subdominio de las Rutas de Fortify
    |--------------------------------------------------------------------------
    |
    | Puedes especificar un prefijo para todas las rutas que Fortify registra.
    | También puedes configurar un subdominio específico para estas rutas.
    |
    */
    'prefix' => '',

    'domain' => null,

    /*
    |--------------------------------------------------------------------------
    | Middleware de las Rutas de Fortify
    |--------------------------------------------------------------------------
    |
    | Aquí se especifica qué middleware se aplicará a las rutas registradas por
    | Fortify. El valor por defecto es 'web', que es el recomendado.
    |
    */
    'middleware' => ['web'],

    /*
    |--------------------------------------------------------------------------
    | Limitación de Peticiones (Rate Limiting)
    |--------------------------------------------------------------------------
    |
    | Por defecto, Fortify limitará los intentos de login a 5 solicitudes por minuto
    | para cada combinación de email e IP. Puedes especificar un limitador de peticiones
    | personalizado si lo consideras necesario.
    |
    */
    'limiters' => [
        'login' => 'login',
        'two-factor' => 'two-factor',
    ],

    /*
    |--------------------------------------------------------------------------
    | Rutas de Vista de Registro
    |--------------------------------------------------------------------------
    |
    | Aquí puedes especificar si deseas que Fortify registre las rutas que retornan
    | vistas. Esto es útil si quieres construir una aplicación de una sola página (SPA)
    | y no necesitas que Fortify gestione las vistas.
    |
    */
    'views' => true,

    /*
    |--------------------------------------------------------------------------
    | Funcionalidades (Features)
    |--------------------------------------------------------------------------
    |
    | Algunas funcionalidades de Fortify son opcionales y pueden ser deshabilitadas
    | eliminándolas de este arreglo. En este ejemplo se han habilitado el registro,
    | reinicio de contraseñas, actualización de información de perfil, actualización
    | de contraseñas y autenticación de dos factores.
    |
    */
    'features' => [
        //Features::registration(),           // Permite el registro de nuevos usuarios.
        Features::resetPasswords(),           // Permite reiniciar la contraseña.
        // Features::emailVerification(),     // Verificación de correo electrónico (desactivada en este ejemplo).
        Features::updateProfileInformation(), // Permite actualizar la información del perfil.
        Features::updatePasswords(),          // Permite cambiar la contraseña.
        Features::twoFactorAuthentication([   // Configura la autenticación de dos factores.
            'confirm' => true,
            'confirmPassword' => true,
            // 'window' => 0,                  // Ventana de validez del código (opcional).
        ]),
    ],

];
