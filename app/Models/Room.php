<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Reservation;
use App\Models\RoomImage;


class Room extends Model
{
    use HasFactory, SoftDeletes;
  
    protected $fillable = [
        'type_name',
        'description',
        'price',
        'capacity',
        'total_rooms',
        'plan',
    ];
  
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

 
    



    public function images()
    {
        return $this->hasMany(RoomImage::class)->orderBy('sort_order');
    }

    public function getPrimaryImageUrlAttribute()
    {
        return optional($this->images->first())->image_url;
    }
}
