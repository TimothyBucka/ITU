<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class body_data_factoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'height' => fake()->randomFloat('2', '150', '200'),
            'weight' => fake()->randomFloat('2', '60', '110'),
            'age' => fake()->numberBetween('20', '45'),
            'goal_target' => fake()->randomFloat('2', '50', '85'),
            'bmi' => fake()->randomFloat('2', '18', '25'),
        ];
    }
}
