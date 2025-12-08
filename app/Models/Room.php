<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\RoomImage;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    // 💡 フィルアブル設定は全てここに統合
    protected $fillable = [
        'type_name',
        'description',
        'price',
        'capacity',
        'total_rooms',
        // 'image_url'はroom_imagesテーブルにあるため不要
    ];

    /**
     * この部屋タイプが持つ複数の画像を取得 (HasMany)
     * 表示順 (sort_order) で並び替える
     */
    public function images()
    {
        // 💡 RoomImage::class が必要ですが、まだRoomImageモデルのコードがありません。
        //    必要に応じて use App\Models\RoomImage; を追加してください。
        return $this->hasMany(\App\Models\RoomImage::class)->orderBy('sort_order');
    }

    /**
     * 代表画像 (一番最初に登録された画像) のURLを取得するためのアクセサ
     */
    public function getPrimaryImageUrlAttribute()
    {
        // 最初の画像を返す。画像がない場合は空文字列を返す
        return $this->images->first()->image_url ?? '';
    }
}
