<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre', 'descripcion', 'precio', 'iva',
    ];

    // Relación N:M con User (clientes) a través de carrito
    public function clientes()
    {
        return $this->belongsToMany(User::class, 'carrito', 'producto_id', 'user_id');
    }

    // Un producto puede estar en muchas líneas de pedido
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'producto_id');
    }

    // Accessor para IVA (21% del precio)
    public function getIvaAttribute($value)
    {
        return round($this->precio * 0.21, 2);
    }
}
