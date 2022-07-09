<?php

namespace Database\Factories;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'label' => $this->faker->sentence(4),
            'status' => $this->faker->randomElement([
                JobStatus::Active,
                JobStatus::Scheduled,
                JobStatus::Completed,
                JobStatus::ToPriced,
                JobStatus::Invoicing,
            ]),
            'description' => $this->faker->sentence(4),
        ];
    }
}
