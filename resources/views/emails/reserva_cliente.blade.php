{{-- resources/views/emails/reserva_cliente.blade.php --}}
<x-mail::message>
# ¡Reserva confirmada!

Hola {{ $reserva->cliente->name }},

Tu reserva para la actividad **{{ $actividad->nombre }}** ha sido confirmada.

- **Fecha:** {{ $cita->fecha }}
- **Hora:** {{ $cita->hora_inicio }}
- **Duración:** {{ $cita->duracion }} minutos

Si tienes alguna duda, contacta con nosotros.

¡Te esperamos!

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
