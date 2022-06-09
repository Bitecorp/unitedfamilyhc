<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
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
            'ssn' => $this->faker->word,
            'birth_date' => $this->faker->word,
            'marital_status' => $this->faker->word,
            'email' => $this->faker->word,
            'email_verified_at' => $this->faker->date('Y-m-d H:i:s'),
            'password' => $this->faker->word,
            'role_id' => $this->faker->word,
            'statu_id' => $this->faker->word,
            'remember_token' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s'),
            'companie_agent' => $this->faker->word
        ];
    }
}
