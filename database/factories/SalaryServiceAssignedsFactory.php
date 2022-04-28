<?php

namespace Database\Factories;

use App\Models\SalaryServiceAssigneds;
use Illuminate\Database\Eloquent\Factories\Factory;

class SalaryServiceAssignedsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalaryServiceAssigneds::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
        'service_id' => $this->faker->word,
        'type_salary' => $this->faker->word,
        'salary' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
