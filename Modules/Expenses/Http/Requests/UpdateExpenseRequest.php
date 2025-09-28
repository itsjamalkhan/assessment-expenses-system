<?php
namespace Modules\Expenses\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules(): array
    {
        return [
            'title'        => 'sometimes|required|string|max:255',
            'amount'       => 'sometimes|required|numeric|min:0',
            'category'     => 'sometimes|required|in:food,travel,utilities,other',
            'expense_date' => 'sometimes|required|date',
            'notes'        => 'nullable|string',
        ];
    }
}
