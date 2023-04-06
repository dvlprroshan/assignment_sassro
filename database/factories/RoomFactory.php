<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\RoomCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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
            'room_no' => fake()->unique()->randomNumber(3),
            'category' => fake()->randomElement(RoomCategory::pluck('id')->toArray() ?? []),
            'status' => 'Available',
            'alloted_to' => '',
        ];
    }
}
