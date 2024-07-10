<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class KoudenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'section' => $this->faker->randomElement([1,2,3,4,5,6,7,8]),
            'post' => $this->faker->post(),
            'name_kaan' => $this->faker->name_kan(),
            'relation' => $this->faker->relation(),
            'address' => $this->faker->address(),
            'price' => $this->faker->pice(),
            'memo' => $this->faker->realText(),
            'created_at' => $this->faker->date(),
        ];
    }
}
