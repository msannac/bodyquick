<tfoot id="carrito-tfoot">
@php $total = 0; @endphp
@foreach($carrito as $item)
    @php
        $subtotal = $item->precio_unitario * $item->cantidad;
        $iva = $item->iva * $item->cantidad / 100 * $item->precio_unitario;
        $total += $subtotal + $iva;
    @endphp
@endforeach
<tr>
    <th colspan="4" class="text-right">Total:</th>
    <th colspan="2">{{ number_format($total, 2) }} €</th>
</tr>
</tfoot>
