{{-- resources/views/emails/reserva_admin.blade.php --}}
<x-mail::message>
# Nueva reserva realizada

Se ha realizado una nueva reserva en Bodyquick.

- **Cliente:** {{ $cliente->name }} ({{ $cliente->email }})
- **Actividad:** {{ $actividad->nombre }}
- **Fecha:** {{ $cita->fecha }}
- **Hora:** {{ $cita->hora_inicio }}
- **Duración:** {{ $cita->duracion }} minutos

Puedes consultar los detalles en el panel de administración.

Gracias,<br>
{{ config('app.name') }}
</x-mail::message>
