<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'nik' => $this->faker->unique()->numerify('EMP###'),
            'full_name' => $this->faker->name(),
            'position' => $this->faker->jobTitle(),
            'phone_number' => $this->faker->phoneNumber(),
            'password' => bcrypt('password'),
        ];
    }
}
