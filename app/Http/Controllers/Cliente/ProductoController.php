<?php
namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('Cliente.indexProducto', compact('productos'));
    }
}
