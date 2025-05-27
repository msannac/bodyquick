<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id', 'producto_id', 'nombre', 'precio_unitario', 'cantidad', 'iva', 'subtotal',
    ];

    // Una línea pertenece a un pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Una línea pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }
}
