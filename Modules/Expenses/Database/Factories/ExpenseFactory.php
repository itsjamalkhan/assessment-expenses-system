<?php

namespace Modules\Expenses\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\Expenses\Models\Expense;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Expenses\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    protected $model = Expense::class;

    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(), // auto-generate UUID
            'title' => $this->faker->sentence(3),
            'amount' => $this->faker->randomFloat(2, 5, 500),
            'category' => $this->faker->randomElement(['food', 'travel', 'utilities', 'other']),
            'expense_date' => $this->faker->date(),
            'notes' => $this->faker->optional()->sentence(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
