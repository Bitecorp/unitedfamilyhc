<?php

namespace Database\Factories;

use App\Models\JobInformation;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobInformationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = JobInformation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
            'title' => $this->faker->word,
            'supervisor' => $this->faker->word,
            'work_name_location' => $this->faker->word,
            'work_phone' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
