<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id', 'total', 'status', 'payment_id', 'factura_pdf',
    ];

    // Un pedido pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un pedido tiene muchas líneas
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
