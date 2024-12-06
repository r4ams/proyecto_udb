<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'capacity', 'status'];

    // Relación uno a muchos con Reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    // Relación uno a muchos con Orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
