<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Plan>
 */
class PlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'price' => fake()->randomFloat(2, 0, 100),
            'currency' => 'USD',
            'billing_interval' => fake()->randomElement(['month', 'year', 'lifetime']),
            'features' => [],
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
