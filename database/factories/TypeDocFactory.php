<?php

namespace Database\Factories;

use App\Models\TypeDoc;
use Illuminate\Database\Eloquent\Factories\Factory;

class TypeDocFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TypeDoc::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_doc' => $this->faker->word,
            'document_certificate' => $this->faker->word,
            'created_at' => $this->faker->date('Y-m-d H:i:s'),
            'updated_at' => $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
