<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->title,
            'name' => $this->faker->name,
            'gender' => $this->faker->randomElement(['M', 'F']),
            'phone_number' => '08' . $this->faker->randomNumber(8),
            'image' => $this->faker->imageUrl(),
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
