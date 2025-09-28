<?php

namespace Modules\Expenses\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Modules\Expenses\Http\Requests\StoreExpenseRequest;
use Modules\Expenses\Http\Requests\UpdateExpenseRequest;
use Modules\Expenses\Services\ExpenseService;
use Modules\Expenses\Resources\ExpenseResource;
use Modules\Expenses\Models\Expense;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;

/**
 * @OA\Info(
 *     title="Expense Management API",
 *     version="1.0.0",
 *     description="API documentation for managing expenses"
 * )
 *
 * @OA\Tag(
 *     name="Expenses",
 *     description="Endpoints for managing expenses"
 * )
 */

class ExpenseController extends BaseController
{
    public function __construct(protected ExpenseService $service) {}

    /**
     * @OA\Get(
     *     path="/api/expenses",
     *     summary="List all expenses",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="category",
     *         in="query",
     *         description="Filter by category",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="from",
     *         in="query",
     *         description="Filter from date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="to",
     *         in="query",
     *         description="Filter to date (YYYY-MM-DD)",
     *         required=false,
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful response with list of expenses"
     *     )
     * )
     */

    public function index()
    {
        $filters = request()->only(['category','from','to']);
        $expenses = $this->service->listExpenses($filters);
        return ExpenseResource::collection($expenses)
              ->response()
              ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/expenses",
     *     summary="Create a new expense",
     *     tags={"Expenses"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title","amount","category","expense_date"},
     *             @OA\Property(property="title", type="string", example="Office Supplies"),
     *             @OA\Property(property="amount", type="number", format="float", example=120.50),
     *             @OA\Property(property="category", type="string", example="Stationery"),
     *             @OA\Property(property="expense_date", type="string", format="date", example="2025-09-27"),
     *             @OA\Property(property="notes", type="string", example="Purchased from ABC Store")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Expense successfully created"
     *     )
     * )
     */

    public function store(StoreExpenseRequest $request)
    {
        $expense = $this->service->createExpense($request->validated());
        return (new ExpenseResource($expense))
               ->response()
               ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/api/expenses/{id}",
     *     summary="Get a single expense by ID",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID of the expense",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense details"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */

    public function show(string $id)
    {
        $expense = Expense::findOrFail($id);
        return (new ExpenseResource($expense));
    }

    /**
     * @OA\Put(
     *     path="/api/expenses/{id}",
     *     summary="Update an existing expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID of the expense",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Office Supplies"),
     *             @OA\Property(property="amount", type="number", format="float", example=150.00),
     *             @OA\Property(property="category", type="string", example="Office"),
     *             @OA\Property(property="expense_date", type="string", format="date", example="2025-09-28"),
     *             @OA\Property(property="notes", type="string", example="Updated purchase details")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Expense successfully updated"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $updated = $this->service->updateExpense($expense, $request->validated());
        return (new ExpenseResource($updated))
               ->response()
               ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/expenses/{id}",
     *     summary="Delete an expense",
     *     tags={"Expenses"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="UUID of the expense",
     *         @OA\Schema(type="string", format="uuid")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Expense deleted successfully (no content)"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Expense not found"
     *     )
     * )
     */

    public function destroy(Expense $expense)
    {
        $this->service->deleteExpense($expense);
        return response()->noContent(); // 204
    }
}
