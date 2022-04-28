<?php

namespace Database\Factories;

use App\Models\DataFile;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataFileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataFile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'url' => $this->faker->word,
            'path' => $this->faker->word,
            'ext' => $this->faker->word,
            'mime_type' => $this->faker->word,
            'status' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}