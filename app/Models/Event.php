<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'location', 'date', 'time'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function rsvps() {
        return $this->hasMany(RSVP::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function participants() {
        return $this->belongsToMany(User::class, 'rsvps')->withPivot('status')->withTimestamps();
    }
}
