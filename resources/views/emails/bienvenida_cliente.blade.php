<x-mail::message>
# ¡Bienvenido/a, {{ $user->name }}!

Te damos la bienvenida a Bodyquick. Estos son tus datos de acceso:

- **Nombre:** {{ $user->name }}
- **Correo electrónico:** {{ $user->email }}
- **Contraseña:** {{ $password }}

> **Por motivos de seguridad, le recomendamos encarecidamente que cambie la contraseña temporal proporcionada en este correo tras su primer acceso a la plataforma.**

Puede acceder a su cuenta desde el siguiente enlace:

<x-mail::button :url="url('/')">
Acceder a Bodyquick
</x-mail::button>

@if($verificationUrl)
---

**Antes de poder acceder a todas las funcionalidades, debe verificar su correo electrónico:**

<x-mail::button :url="$verificationUrl">
Verificar mi correo
</x-mail::button>
@endif

Si tiene alguna duda, no dude en contactarnos.

¡Gracias por confiar en nosotros!<br>
{{ config('app.name') }}
</x-mail::message>
