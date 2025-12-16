<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'room_id',
        'check_in',
        'guests',
        'total_price',
        'status',
    ];

     // check_in と check_out を Carbonに変換するキャスト
    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];
   
  

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }



}
