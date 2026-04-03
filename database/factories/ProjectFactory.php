<?php

namespace Database\Factories;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class ProjectFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => substr(fake()->name(), 0, 20),
            'description' => substr(fake()->text(), 0, 255),
            'status' => $this->faker->randomElement(Status::values()),
            'goals' => substr(fake()->text(), 0, 150),
            'user_id' => 2,
        ];
    }
}
