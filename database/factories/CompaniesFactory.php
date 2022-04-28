<?php

namespace Database\Factories;

use App\Models\Companies;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompaniesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Companies::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'street_addres' => $this->faker->word,
            'apartment_unit' => $this->faker->word,
            'city' => $this->faker->word,
            'state' => $this->faker->word,
            'zip_code' => $this->faker->word,
            'home_phone' => $this->faker->word,
            'alternate_phone' => $this->faker->word,
            'ssn' => $this->faker->word,
            'email' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
