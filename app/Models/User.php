<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*-----------------錦織追加分-------------------------*/
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// 簡易ログイン認証用
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'role',
        'status'
    ];

/*---------------------------------------------------*/
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

}
