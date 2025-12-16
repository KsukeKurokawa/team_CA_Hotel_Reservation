<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'image_url',
        'sort_order',
    ];

    /**
     * この画像がどの部屋タイプに属するかを定義
     */
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
