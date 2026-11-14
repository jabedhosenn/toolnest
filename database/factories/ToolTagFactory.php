<?php

namespace Database\Factories;

use App\Models\Tool;
use App\Models\ToolTag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ToolTag>
 */
class ToolTagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->word();

        return [
            'tool_id' => Tool::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
