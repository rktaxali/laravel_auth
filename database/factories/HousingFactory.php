<?php

namespace Database\Factories;

use App\Models\Housing;
use Illuminate\Database\Eloquent\Factories\Factory;

class HousingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Housing::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address,
        ];

    }
}
