@php $total = 0; @endphp
@foreach($carrito as $item)
    @php
        $subtotal = $item->precio_unitario * $item->cantidad;
        $iva = $item->iva * $item->cantidad / 100 * $item->precio_unitario;
        $total += $subtotal + $iva;
    @endphp
    <tr>
        <td>{{ $item->producto->nombre }}</td>
        <td>{{ number_format($item->precio_unitario, 2) }} €</td>
        <td>
            <input type="number" class="input-cantidad-carrito" data-carrito-id="{{ $item->id }}" value="{{ $item->cantidad }}" min="1" style="width:60px;">
        </td>
        <td>{{ $item->iva ?? 21 }} %</td>
        <td>{{ number_format($subtotal + $iva, 2) }} €</td>
        <td>
            <button type="button" class="btn btn-sm btn-danger btn-eliminar-carrito" data-carrito-id="{{ $item->id }}" data-nombre="{{ $item->producto->nombre }}">Eliminar</button>
        </td>
    </tr>
@endforeach
