<?php

namespace Database\Factories;

use App\Models\DocumentUserFiles;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentUserFilesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DocumentUserFiles::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomDigitNotNull,
            'document_id' => $this->faker->randomDigitNotNull,
            'date_expedition' => $this->faker->word,
            'date_expired' => $this->faker->word,
            'file' => $this->faker->word
        ];
    }
}
