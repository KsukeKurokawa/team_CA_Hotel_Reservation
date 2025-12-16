<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
        Room::create([
            'type_name' => 'premium room',
            'description' => '高級スイートルーム プレミアム',
            'price' => 200000,
            'capacity' => 4,
            'total_rooms' => 2,
            'plan' => 0,
        ]);

        Room::create([
            'type_name' => 'standard room',
            'description' => 'スタンダードルーム',
            'price' => 120000,
            'capacity' => 4,
            'total_rooms' => 3,
            'plan' => 0,
        ]);

}

}
