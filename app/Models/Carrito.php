<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrito extends Model
{
    use HasFactory;

    protected $table = 'carrito';

    protected $fillable = [
        'producto_id', 'user_id', 'cantidad', 'precio_unitario', 'iva',
    ];

    // Un ítem de carrito pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un ítem de carrito pertenece a un producto
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
