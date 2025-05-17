@foreach($citas as $loopIndex => $cita)
<tr data-index="{{ $loopIndex }}">
    <td class="fecha-col">{{ $cita->fecha }}</td>
    <td class="hueco-col">{{ $cita->hueco }}</td>
    <td>{{ $cita->aforo }}</td>
    <td>{{ $cita->hora_inicio }}</td>
    <td>{{ $cita->duracion }}</td>
    <td>{{ $cita->frecuencia }}</td>
    <td>{{ $cita->actividad->nombre ?? 'N/A' }}</td>
    <td>
        <div class="btn-group-acciones">
            <a href="{{ route('admin.citas.editar', $cita) }}" class="btn-custom-editar abrirModal" data-url="{{ route('admin.citas.editar', $cita) }}">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form method="POST" action="{{ route('admin.citas.eliminar', $cita) }}" style="display:inline;">
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
