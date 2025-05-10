<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Products;

class Expenses extends Model
{
    use HasFactory;

    protected $table = 'expenses';
    protected $fillable = [
        'month',
        'expenses_current',
        'expenses_previous',
        'expenses_next',
    ];

    protected $appends = [
        'expenses_products',
        'highest_spending_product',
        'lowest_spending_product',
    ];

    /**
     *
     * @return float
     */
    public function getExpensesProductsAttribute(): float
    {
        return Products::sum('price');
    }

    /**
     *
     * @return string|null
     */
    public function getHighestSpendingProductAttribute(): ?string
    {
        return Products::orderByDesc('price')->value('name');
    }

    /**
     *
     * @return string|null
     */
    public function getLowestSpendingProductAttribute(): ?string
    {
        return Products::orderBy('price')->value('name');
    }
}
