<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EventUser extends Pivot
{
    protected $table = 'event_user'; // o como se llame tu tabla
    protected $fillable = ['user_id', 'event_id', 'status'];
    public $timestamps = true;
}
