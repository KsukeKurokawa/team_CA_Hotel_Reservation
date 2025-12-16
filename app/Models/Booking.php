<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'room_id',
        'room_count',
        'guest_count',
        'selected_plans',
        'check_in_date',
        'check_out_date',
        'total_price',
        'user_id',
    ];

    protected $casts = [
        'selected_plans' => 'array',
        'check_in_date' => 'datetime',
        'check_out_date' => 'datetime',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
