<?php
namespace Modules\Expenses\Events;

use Modules\Expenses\Models\Expense;

class ExpenseCreated
{
    public function __construct(public Expense $expense) {}
}
