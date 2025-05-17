@foreach($clientes as $cliente)
<tr>
    <td>{{ $cliente->name }}</td>
    <td>{{ $cliente->apellidos }}</td>
    <td>{{ $cliente->email }}</td>
    <td>{{ $cliente->dni }}</td>
    <td>{{ $cliente->telefono }}</td>
    <td>
        <div class="btn-group-acciones">
            <a href="{{ route('admin.clientes.editar', $cliente) }}" class="btn-custom-editar abrirModal" data-url="{{ route('admin.clientes.editar', $cliente) }}">
                <i class="fas fa-edit"></i> Editar
            </a>
            <form method="POST" action="{{ route('admin.clientes.eliminar', $cliente) }}" style="display:inline;">
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
