{{-- resources/views/emails/reserva_actualizada_admin.blade.php --}}
<x-mail::message>
# Reserva actualizada por el cliente

Un cliente ha actualizado una reserva en Bodyquick.

- **Cliente:** {{ $cliente->name }} ({{ $cliente->email }})
- **Actividad:** {{ $actividad->nombre }}
- **Fecha:** {{ $cita->fecha }}
- **Hora:** {{ $cita->hora_inicio }}
- **Duración:** {{ $cita->duracion }} minutos

Puedes consultar los detalles en el panel de administración.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
