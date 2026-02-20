<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transaction>
 */
class TransactionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'type'        => fake()->randomElement(['income', 'expense']),
            'amount'      => fake()->numberBetween(100, 100000),
            'description' => fake()->sentence(3),
            'notes'       => fake()->optional()->sentence(),
            'date'        => fake()->dateTimeThisYear(),
        ];
    }
}
