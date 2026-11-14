<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Tool;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Tool>
 */
class ToolFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);
        $slug = Str::slug($name);

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => $slug,
            'description' => fake()->sentence(),
            'icon' => fake()->randomElement(['text', 'sparkles', 'image', 'file', 'files', 'video', 'audio', 'code', 'zap']),
            'route_name' => 'tools.'.$slug,
            'component_identifier' => $slug,
            'is_featured' => false,
            'is_popular' => false,
            'is_active' => true,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
