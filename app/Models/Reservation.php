<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = ['table_id', 'customer_name', 'phone', 'reservation_date', 'party_size'];

    // Relación muchos a uno con Table
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
