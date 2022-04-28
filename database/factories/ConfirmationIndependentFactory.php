<?php

namespace Database\Factories;

use App\Models\ConfirmationIndependent;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfirmationIndependentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConfirmationIndependent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
            'independent_contractor' => $this->faker->word,
            'personalEmpresa' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
