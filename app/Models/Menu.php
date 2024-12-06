<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'type'];

    // Relación uno a muchos con OrderDetails
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
