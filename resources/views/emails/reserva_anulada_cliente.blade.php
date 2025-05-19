{{-- resources/views/emails/reserva_anulada_cliente.blade.php --}}
<x-mail::message>
# Reserva anulada

Hola {{ $reserva->cliente->name }},

Te informamos que tu reserva para la actividad **{{ $actividad->nombre }}** ha sido anulada.

- **Fecha:** {{ $cita->fecha }}
- **Hora:** {{ $cita->hora_inicio }}
- **Duración:** {{ $cita->duracion }} minutos

Si tienes alguna duda, contacta con nosotros.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
