<?php

use Illuminate\Support\Facades\Route;
use Modules\Expenses\Http\Controllers\ExpenseController;

// Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
//     Route::apiResource('expenses', ExpensesController::class)->names('expenses');
// });

// Route::apiResource('expenses', ExpenseController::class);

Route::prefix('expenses')->group(function () {
    Route::post('/', [ExpenseController::class, 'store']);
    Route::get('/', [ExpenseController::class, 'index']);
    Route::get('/{id}', [ExpenseController::class, 'show']);
    Route::put('/{id}', [ExpenseController::class, 'update']);
    Route::delete('/{id}', [ExpenseController::class, 'destroy']);
}); 
