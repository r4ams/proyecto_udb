<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'customer_name', 'status', 'comments', 'total'];

    // Relación muchos a uno con Table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    // Relación uno a muchos con OrderDetails
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
