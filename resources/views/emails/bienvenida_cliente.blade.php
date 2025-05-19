<x-mail::message>
# ¡Bienvenido/a, {{ $user->name }}!

Te damos la bienvenida a Bodyquick. Estos son tus datos de acceso:

- **Nombre:** {{ $user->name }}
- **Correo electrónico:** {{ $user->email }}
- **Contraseña:** {{ $password }}

Puedes acceder a tu cuenta desde el siguiente enlace:

<x-mail::button :url="url('/')">
Acceder a Bodyquick
</x-mail::button>

@if($verificationUrl)
---

**Antes de poder acceder a todas las funcionalidades, debes verificar tu correo electrónico:**

<x-mail::button :url="$verificationUrl">
Verificar mi correo
</x-mail::button>
@endif

Si tienes alguna duda, no dudes en contactarnos.

¡Gracias por confiar en nosotros!<br>
{{ config('app.name') }}
</x-mail::message>
