<?php

namespace Database\Factories;

use App\Models\SubServices;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubServicesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubServices::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'service_id' => $this->faker->word,
        'name_sub_service' => $this->faker->word,
        'price_sub_service' => $this->faker->word,
        'config_validate' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
