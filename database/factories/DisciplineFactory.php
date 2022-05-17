<?php

namespace Database\Factories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class DisciplineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Discipline::class;

    public function definition()
    {
        return [
            'name_discipline' => $this->faker->text(100),
            'image_discipline' => $this->faker->text(100),
        ];
    }
}
