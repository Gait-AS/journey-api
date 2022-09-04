<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $team_id = fake()->numberBetween(1, 3);
        $assigned_to = fake()->randomElement(User::where('team_id', $team_id)->pluck('id')->toArray());

        $status = fake()->randomElement(['todo', 'doing', 'review', 'done']);

        if ($status === 'done') {
            $completed_at = fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d H:i:s');
        } else {
            $completed_at = null;
        }

        return [
            'name' => fake()->word(),
            'content' => fake()->sentence(),
            'created_by' => fake()->numberBetween(1, 30),
            'assigned_to' => $assigned_to,
            'status' => $status,
            'completed_at' => $completed_at,
            'team_id' => $team_id,
        ];
    }
}
