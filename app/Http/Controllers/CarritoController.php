<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Carrito;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
                    .'<a href="#" class="btn btn-success float-right">Finalizar compra</a>';
            }
            return response($html);
        }
        // Petición normal: vista completa (para fallback/desarrollo)
        return view('carrito.index', compact('carrito'));
    }

    // Añadir producto al carrito (solo responde JSON)
    public function agregar(Request $request)
    {
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
        Log::info('CarritoController@eliminar - INICIO', [
            'user_id' => Auth::id(),
            'carrito_id' => $id,
        ]);
        $carrito = Carrito::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$carrito) {
            Log::warning('CarritoController@eliminar - Carrito no encontrado', ['carrito_id' => $id, 'user_id' => Auth::id()]);
            return response()->json(['success' => false, 'message' => 'Producto no encontrado en el carrito'], 404);
        }
        $carrito->delete();
        Log::info('CarritoController@eliminar - Producto eliminado', ['carrito_id' => $id]);
        // Obtener el carrito actualizado
        $carritoActualizado = Carrito::with('producto')
            ->where('user_id', Auth::id())
            ->get();
        // Renderizar el HTML actualizado del tbody y tfoot
        $tbody = view('carrito._tbody', ['carrito' => $carritoActualizado])->render();
        $tfoot = view('carrito._tfoot', ['carrito' => $carritoActualizado])->render();
        // Si el carrito está vacío, enviar mensaje especial
        $empty = $carritoActualizado->isEmpty();
        Log::info('CarritoController@eliminar - Respuesta final', ['empty' => $empty]);
        return response()->json([
            'success' => true,
            'html' => $tbody,
            'tfoot' => $tfoot,
            'empty' => $empty
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
}
