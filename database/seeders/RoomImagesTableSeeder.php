<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomImage;
use App\Models\Room;

class RoomImagesTableSeeder extends Seeder
{
    public function run(): void
    {
        RoomImage::truncate();

        // --- スタンダードルーム (ID: 1) 用の画像5枚 ---
        RoomImage::create([
            'room_id'    => 1,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_1',
            'sort_order' => 1,
        ]);

        RoomImage::create([
            'room_id'    => 1,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_2',
            'sort_order' => 2,
        ]);

        RoomImage::create([
            'room_id'    => 1,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_3',
            'sort_order' => 3,
        ]);

        RoomImage::create([
            'room_id'    => 1,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_4',
            'sort_order' => 4,
        ]);

        RoomImage::create([
            'room_id'    => 1,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_5',
            'sort_order' => 5,
        ]);

        // --- スタンダードルーム (ID: 2) 用の画像5枚 ---
        RoomImage::create([
            'room_id'    => 2,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_1',
            'sort_order' => 1,
        ]);

        RoomImage::create([
            'room_id'    => 2,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_2',
            'sort_order' => 2,
        ]);

        RoomImage::create([
            'room_id'    => 2,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_3',
            'sort_order' => 3,
        ]);

        RoomImage::create([
            'room_id'    => 2,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_4',
            'sort_order' => 4,
        ]);

        RoomImage::create([
            'room_id'    => 2,
            'image_url'  => 'https://placehold.jp/24/555555/ffffff/800x600.png?text=Standard_5',
            'sort_order' => 5,
        ]);
    }
}
