<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;

class PedidoController extends Controller
{
    // Muestra el historial de pedidos del usuario autenticado
    public function historial()
    {
        $user = Auth::user();
        $pedidos = Order::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pedidos.historial', compact('pedidos'));
    }
}
