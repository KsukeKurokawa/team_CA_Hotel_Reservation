<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Room;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservation>
 */
class ReservationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::inRandomOrder()->first()->id ?? User::factory(),
            'room_id'=>Room::inRandomOrder()->first()->id ?? Room::factory(),
            'check_in'=>fake()->dateTimeBetween('now','+1 week')->format('Y-m-d'),
            'guests'=>fake()->numberBetween(1,4),
            'total_price'=>fake()->numberBetween(5000,20000)
        ];
    }
}
