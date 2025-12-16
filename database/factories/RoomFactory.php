<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_name'   => fake()->unique()->randomElement(['プレミアム', 'スタンダード', 'デラックス', 'エコノミー']),
            'description' => fake()->optional()->sentence(8),
            'price'       => fake()->numberBetween(5000, 20000),
            'capacity'    => fake()->numberBetween(1, 4),
            'total_rooms' => fake()->numberBetween(1, 5),
            'plan'        => 0,


        ];
    }
}
