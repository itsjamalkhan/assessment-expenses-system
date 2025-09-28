<?php
namespace Modules\Expenses\Services;

use Modules\Expenses\Models\Expense;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Modules\Expenses\Events\ExpenseCreated; // optional event

class ExpenseService
{
    public function createExpense(array $data): Expense
    {
        return DB::transaction(function () use ($data) {
            $expense = Expense::create($data);

            // dispatch event (optional)
            event(new ExpenseCreated($expense));

            return $expense;
        });
    }

    public function updateExpense(Expense $expense, array $data): Expense
    {
        return DB::transaction(function () use ($expense, $data) {
            $expense->update($data);
            return $expense;
        });
    }

    public function deleteExpense(Expense $expense): void
    {
        $expense->delete();
    }

    public function listExpenses(array $filters = [])
    {
        $query = Expense::query();

        if (!empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }
        if (!empty($filters['from']) && !empty($filters['to'])) {
            $query->whereBetween('expense_date', [$filters['from'], $filters['to']]);
        }

        return $query->orderBy('expense_date','desc')->get();
    }
}
