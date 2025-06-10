<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Mostrar listado de productos
    public function listar()
    {
        $productos = Producto::all();
        return view('Admin.Productos.index', compact('productos'));
    }

    // Mostrar formulario de creación
    public function crear()
    {
        return view('Admin.Productos.crear');
    }

    // Guardar nuevo producto
    public function guardar(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'foto' => 'nullable|image|max:2048',
        ]);
        $producto = new Producto($validated);
        $producto->iva = $producto->precio * 0.21;
        // Guardar la foto si se sube
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('productos', 'public');
            $producto->foto = $path;
        }
        $producto->save();
        return redirect()->route('admin.productos.listar')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar formulario de edición
    public function editar(Producto $producto)
    {
        return view('Admin.Productos.editar', compact('producto'));
    }

    // Actualizar producto
    public function actualizar(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'foto' => 'nullable|image|max:2048',
        ]);
        $producto->fill($validated);
        $producto->iva = $producto->precio * 0.21;
        // Si se sube una nueva foto, la guardamos y reemplazamos la anterior
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('productos', 'public');
            $producto->foto = $path;
        }
        $producto->save();
        return redirect()->route('admin.productos.listar')->with('success', 'Producto actualizado correctamente.');
    }

    // Eliminar producto
    public function eliminar(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('admin.productos.listar')->with('success', 'Producto eliminado correctamente.');
    }
}
