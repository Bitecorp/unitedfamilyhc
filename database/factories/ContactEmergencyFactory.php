<?php

namespace Database\Factories;

use App\Models\ContactEmergency;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactEmergencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactEmergency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->word,
            'first_name' => $this->faker->word,
            'last_name' => $this->faker->word,
            'mi' => $this->faker->word,
            'street_addres' => $this->faker->word,
            'apartment_unit' => $this->faker->word,
            'city' => $this->faker->word,
            'state' => $this->faker->word,
            'zip_code' => $this->faker->word,
            'home_phone' => $this->faker->word,
            'alternate_phone' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
