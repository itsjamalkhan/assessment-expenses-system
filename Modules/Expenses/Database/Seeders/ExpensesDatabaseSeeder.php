<?php

namespace Modules\Expenses\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Expenses\Models\Expense;
class ExpensesDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Expense::factory()->count(5)->create();
    }
}
