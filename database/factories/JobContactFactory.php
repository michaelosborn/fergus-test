<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JobContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'contact_number' => $this->faker->phoneNumber(),
            'preferred_time_to_call' => $this->faker->dayOfWeek().' '.'midday',
        ];
    }
}
