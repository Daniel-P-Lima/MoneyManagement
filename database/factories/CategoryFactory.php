<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name'       => fake()->word(),
            'color'      => fake()->hexColor(),
            'type'       => fake()->randomElement(['income', 'expense', 'both']),
            'icon_id'    => null,
            'is_default' => false,
        ];
    }
}
