<?php

namespace Database\Factories;

use App\Models\ReferencesPersonales;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferencesPersonalesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferencesPersonales::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
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
