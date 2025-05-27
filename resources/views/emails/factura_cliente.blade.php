<x-mail::message>
# ¡Gracias por tu compra!

Adjuntamos la factura de tu pedido realizado en Bodyquick.

- **Pedido:** #{{ $order->id }}
- **Fecha:** {{ $order->created_at->format('d/m/Y H:i') }}
- **Total:** {{ number_format($order->total, 2) }} €

Si tienes cualquier duda, contacta con nosotros.

¡Gracias por confiar en Bodyquick!
</x-mail::message>
