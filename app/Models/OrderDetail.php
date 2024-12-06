<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_id', 'quantity', 'subtotal'];

    // Relación muchos a uno con Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relación muchos a uno con Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
