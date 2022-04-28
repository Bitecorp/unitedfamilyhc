<?php

namespace Database\Factories;

use App\Models\ReferencesJobsTwo;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReferencesJobsTwoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ReferencesJobsTwo::class;

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
            'name_and_address' => $this->faker->word,
            'position' => $this->faker->word,
            'supervisor' => $this->faker->word,
            'phone_supervisor' => $this->faker->word,
            'dates_employed' => $this->faker->word,
            'to_dates_employed' => $this->faker->word,
            'reason_leaving' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
