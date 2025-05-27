<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use App\Mail\FacturaClienteMail;
use Illuminate\Support\Facades\Mail;


class CarritoController extends Controller
{
    // Mostrar el carrito del usuario
    public function index(Request $request)
    {
        $carrito = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();
        // Si la petición es AJAX, devolver solo el contenido del carrito (sin layout)
        if ($request->ajax()) {
            if ($carrito->isEmpty()) {
                // Si está vacío, solo el mensaje
                $html = '<div class="alert alert-info">Tu carrito está vacío.</div>';
            } else {
                $html = '<table class="table table-bordered table-hover">'
                    .'<thead class="thead-dark">'
                    .'<tr>'
                    .'<th>Producto</th><th>Precio</th><th>Cantidad</th><th>IVA</th><th>Subtotal</th><th>Acciones</th>'
                    .'</tr>'
                    .'</thead>'
                    .'<tbody id="carrito-contenido">'
                    .view('carrito._tbody', ['carrito' => $carrito])->render()
                    .'</tbody>'
                    .'<tfoot id="carrito-tfoot">'
                    .view('carrito._tfoot', ['carrito' => $carrito])->render()
                    .'</tfoot>'
                    .'</table>'
                    .'<a href="#" class="btn btn-secondary abrirModal" data-url="'.route('cliente.productos.index').'">Seguir comprando</a>'
                    .'<a href="#" class="btn btn-success float-right" id="btnCheckout">Finalizar compra</a>';
            }
            return response($html);
        }
        // Petición normal: vista completa (para fallback/desarrollo)
        return view('carrito.index', compact('carrito'));
    }

    // Añadir producto al carrito (solo responde JSON)
    public function agregar(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'session_expired' => true,
                'message' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.'
            ], 401);
        }
        Log::info('CarritoController@agregar - LLEGA PETICION', [
            'user_id' => Auth::id(),
            'all' => $request->all(),
            'headers' => $request->headers->all(),
            'isAjax' => $request->ajax(),
            'expectsJson' => $request->expectsJson(),
            'method' => $request->method(),
        ]);
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'nullable|integer|min:1',
        ]);
        Log::info('CarritoController@agregar - INICIO', $request->all());
        $producto = Producto::findOrFail($request->producto_id);
        Log::info('CarritoController@agregar - Producto encontrado', ['producto_id' => $producto->id]);
        $carrito = Carrito::where('user_id', Auth::id())
            ->where('producto_id', $producto->id)
            ->first();
        $cantidad = $request->input('cantidad', 1);
        if ($carrito) {
            $carrito->cantidad += $cantidad;
            $carrito->save();
            Log::info('CarritoController@agregar - Carrito actualizado', ['carrito_id' => $carrito->id, 'nueva_cantidad' => $carrito->cantidad]);
        } else {
            $nuevo = Carrito::create([
                'user_id' => Auth::id(),
                'producto_id' => $producto->id,
                'cantidad' => $cantidad,
                'precio_unitario' => $producto->precio,
                'iva' => $producto->iva,
            ]);
            Log::info('CarritoController@agregar - Carrito creado', ['carrito_id' => $nuevo->id]);
        }
        Log::info('CarritoController@agregar - FIN');
        // --- NUEVO: devolver HTML actualizado del carrito ---
        $carritoActualizado = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();
        $tbody = view('carrito._tbody', ['carrito' => $carritoActualizado])->render();
        $tfoot = view('carrito._tfoot', ['carrito' => $carritoActualizado])->render();
        $empty = $carritoActualizado->isEmpty();
        return response()->json([
            'success' => true,
            'html' => $tbody,
            'tfoot' => $tfoot,
            'empty' => $empty
        ]);
    }

    // Modificar cantidad de un producto en el carrito (solo responde JSON)
    public function modificar(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'session_expired' => true,
                'message' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.'
            ], 401);
        }
        Log::info('CarritoController@modificar - INICIO', [
            'user_id' => Auth::id(),
            'carrito_id' => $id,
            'all' => $request->all(),
            'headers' => $request->headers->all(),
            'isAjax' => $request->ajax(),
            'expectsJson' => $request->expectsJson(),
            'method' => $request->method(),
        ]);
        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);
        $carrito = Carrito::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();
        if (!$carrito) {
            Log::warning('CarritoController@modificar - Carrito no encontrado', ['carrito_id' => $id, 'user_id' => Auth::id()]);
            return response()->json(['success' => false, 'message' => 'Producto no encontrado en el carrito'], 404);
        }
        $carrito->cantidad = $request->cantidad;
        $carrito->save();
        Log::info('CarritoController@modificar - Cantidad actualizada', ['carrito_id' => $id, 'nueva_cantidad' => $carrito->cantidad]);
        // Renderizar partials actualizados
        $carritoActualizado = Carrito::with('producto')->where('user_id', Auth::id())->get();
        $html = view('carrito._tbody', ['carrito' => $carritoActualizado])->render();
        $tfoot = view('carrito._tfoot', ['carrito' => $carritoActualizado])->render();
        $empty = $carritoActualizado->isEmpty();
        Log::info('CarritoController@modificar - Respuesta final', ['empty' => $empty]);
        return response()->json([
            'success' => true,
            'html' => $html,
            'tfoot' => $tfoot,
            'empty' => $empty,
        ]);
    }

    // Eliminar producto del carrito (solo responde JSON)
    public function eliminar($id)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Tu sesión ha expirado. Por favor, inicia sesión de nuevo.',
                'session_expired' => true
            ]);
        }
        Log::info('CarritoController@eliminar - INICIO', [
            'carrito_id' => $id,
        ]);
        $carrito = Carrito::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$carrito) {
            return response()->json([
                'success' => false,
                'message' => 'Producto no encontrado en el carrito.'
            ]);
        }
        $carrito->delete();
        Log::info('CarritoController@eliminar - Producto eliminado', ['carrito_id' => $id]);
        // Obtener el carrito actualizado
        $carritoActualizado = Carrito::with('producto')->where('user_id', Auth::id())->get();
        // Renderizar el HTML actualizado del tbody y tfoot
        $tbody = view('carrito._tbody', ['carrito' => $carritoActualizado])->render();
        $tfoot = view('carrito._tfoot', ['carrito' => $carritoActualizado])->render();
        $empty = $carritoActualizado->isEmpty();
        Log::info('CarritoController@eliminar - Respuesta final', ['empty' => $empty]);
        return response()->json([
            'success' => true,
            'empty' => $empty,
            'html' => $tbody,
            'tfoot' => $tfoot
        ]);
    }

    // Devuelve el número de productos en el carrito del usuario autenticado (AJAX)
    public function contador()
    {
        $count = 0;
        if (Auth::check()) {
            $count = \App\Models\Carrito::where('user_id', Auth::id())->sum('cantidad');
        }
        return response()->json(['count' => $count]);
    }

    // Iniciar checkout con Stripe
    public function checkout(Request $request)
    {
        $user = Auth::user();
        $carrito = Carrito::with('producto')->where('user_id', $user->id)->get();
        if ($carrito->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'El carrito está vacío.'], 400);
        }

        $lineItems = [];
        foreach ($carrito as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->producto->nombre,
                    ],
                    'unit_amount' => intval($item->precio_unitario * 100), // Stripe espera céntimos
                ],
                'quantity' => $item->cantidad,
            ];
        }

        \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        try {
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => url('/checkout/success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/checkout/cancel'),
                'customer_email' => $user->email,
            ]);
            return response()->json(['success' => true, 'id' => $session->id, 'url' => $session->url]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Stripe checkout success
    public function checkoutSuccess(Request $request)
    {
        $user = Auth::user();
        $sessionId = $request->get('session_id');
        // Recuperar el carrito ANTES de vaciarlo
        $carrito = \App\Models\Carrito::with('producto')->where('user_id', $user->id)->get();
        if ($carrito->isEmpty()) {
            return view('carrito.success'); // Ya procesado
        }
        // Calcular total
        $total = 0;
        foreach ($carrito as $item) {
            $subtotal = $item->precio_unitario * $item->cantidad;
            $iva = $item->iva * $item->cantidad / 100 * $item->precio_unitario;
            $total += $subtotal + $iva;
        }
        // Crear el pedido
        $order = \App\Models\Order::create([
            'user_id' => $user->id,
            'total' => $total,
            'status' => 'pagado',
            'payment_id' => $sessionId,
        ]);
        // Crear las líneas del pedido
        foreach ($carrito as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'producto_id' => $item->producto_id,
                'nombre' => $item->producto->nombre,
                'precio_unitario' => $item->precio_unitario,
                'cantidad' => $item->cantidad,
                'iva' => $item->iva,
                'subtotal' => ($item->precio_unitario * $item->cantidad) + ($item->iva * $item->cantidad / 100 * $item->precio_unitario),
            ]);
        }
        // Vaciar el carrito
        \App\Models\Carrito::where('user_id', $user->id)->delete();
        // Generar y guardar la factura PDF
        $pdf = Pdf::loadView('factura', [
            'order' => $order,
            'user' => $user
        ]);
        $pdfPath = 'facturas/factura_' . $order->id . '.pdf';
        Storage::disk('public')->put($pdfPath, $pdf->output());
        // Guardar la ruta en el pedido
        $order->factura_pdf = $pdfPath;
        $order->save();
        // Enviar la factura por email al usuario
        Mail::to($user->email)->send(new FacturaClienteMail($order, $user, $pdfPath));
        // Mostrar la vista de éxito
        return view('carrito.success');
    }

    // Stripe checkout cancel
    public function checkoutCancel(Request $request)
    {
        // Solo muestra una vista de cancelación
        return view('carrito.cancel');
    }
}
