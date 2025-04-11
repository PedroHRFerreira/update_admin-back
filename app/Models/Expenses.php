<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    /** @use HasFactory<\Database\Factories\ExpensesFactory> */
    use HasFactory;

    protected $table = 'expenses';
    protected $fillable = ['expenses_current', 'expenses_previous', 'expenses_next', 'expenses_products', 'highest_spending_product', 'lowest_cost_product'];
}
