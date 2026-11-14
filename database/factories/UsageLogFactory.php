<?php

namespace Database\Factories;

use App\Models\Tool;
use App\Models\UsageLog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UsageLog>
 */
class UsageLogFactory extends Factory
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
            'action' => 'used',
            'metadata' => [],
            'occurred_at' => now(),
        ];
    }
}
