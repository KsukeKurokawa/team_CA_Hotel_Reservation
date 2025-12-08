<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomImage extends Model
{
    use HasFactory;

    // テーブル名が room_images のため、通常は省略可
    // protected $table = 'room_images'; 

    // マスアサインメントを許可するカラム
    protected $fillable = [
        'room_id',
        'image_url', // マイグレーションファイルの 'image_url' に合わせる
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
