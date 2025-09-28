<?php
namespace Modules\Expenses\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Expenses\Database\Factories\ExpenseFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Expense extends Model
{
     use HasFactory;
    protected $table = 'expenses';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id','title','amount','category','expense_date','notes'];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    protected static function newFactory()
    {
        return ExpenseFactory::new();
    }
}
