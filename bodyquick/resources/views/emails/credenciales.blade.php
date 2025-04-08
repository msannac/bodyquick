<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Credenciales de acceso</title>
</head>
<body>
    <h1>¡Bienvenido a BodyQuick!</h1>
    <p>Se ha creado una cuenta para ti con los siguientes datos:</p>
    <ul>
        <li><strong>Email:</strong> {{ $user->email }}</li>
        <li><strong>Contraseña:</strong> {{ $plainPassword }}</li>
    </ul>
    <p>Puedes iniciar sesión en la aplicación web utilizando estas credenciales.</p>
    <p>Saludos,</p>
    <p>El equipo de BodyQuick</p>
</body>
</html>



