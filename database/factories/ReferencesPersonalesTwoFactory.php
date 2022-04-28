<?php

namespace Database\Factories;

use App\Models\ReferencesPersonalesTwo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferencesPersonalesTwoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferencesPersonalesTwo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
            'reference_number' => $this->faker->word,
            'name_job' => $this->faker->word,
            'address' => $this->faker->word,
            'phone' => $this->faker->word,
            'ocupation' => $this->faker->word,
            'time' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
