<?php

namespace Database\Factories;

use App\Models\Tool;
use App\Models\ToolFavorite;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ToolFavorite>
 */
class ToolFavoriteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'tool_id' => Tool::factory(),
        ];
    }
}
