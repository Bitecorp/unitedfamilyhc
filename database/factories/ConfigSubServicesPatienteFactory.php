<?php

namespace Database\Factories;

use App\Models\ConfigSubServicesPatiente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigSubServicesPatienteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConfigSubServicesPatiente::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'salary_service_assigned_id' => $this->faker->word,
        'agent_id' => $this->faker->word,
        'code_patiente' => $this->faker->word,
        'approved_units' => $this->faker->word,
        'date_expedition' => $this->faker->word,
        'date_expired' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
