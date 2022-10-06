<?php

namespace Database\Factories;

use App\Models\ConnectionsExternals;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConnectionsExternalsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ConnectionsExternals::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_connection' => $this->faker->word,
        'server_connection' => $this->faker->word,
        'port_connection' => $this->faker->word,
        'user_connection' => $this->faker->word,
        'password_connection' => $this->faker->word,
        'created_at' => $this->faker->date('Y-m-d H:i:s'),
        'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
