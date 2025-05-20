@foreach($reservas as $reserva)
<tr>
    <td>{{ $reserva->cliente->name ?? '-' }}</td>
    <td>{{ $reserva->cita->actividad->nombre ?? '-' }}</td>
    <td>{{ $reserva->cita->fecha ?? '-' }}</td>
    <td>{{ $reserva->cita->hora_inicio ?? '-' }}</td>
    <td>
        <div class="btn-group-acciones d-flex align-items-center" style="gap: 10px;">
            <a href="{{ route('admin.reservas.editar', $reserva) }}" 
               class="btn-custom-editar abrirModal" 
               data-url="{{ route('admin.reservas.editar', $reserva) }}">
              <i class="fas fa-edit"></i> Editar
            </a>
            <form method="POST" action="{{ route('admin.reservas.eliminar', $reserva) }}" style="display:inline; margin: 0;">
              @csrf
              @method('DELETE')
              <button type="button" class="btn-custom-eliminar btn-eliminar">
                <i class="fas fa-trash-alt"></i> Eliminar
              </button>
            </form>
        </div>
    </td>
</tr>
@endforeach
