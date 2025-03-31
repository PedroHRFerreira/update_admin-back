<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    /** @use HasFactory<\Database\Factories\SalesFactory> */
    use HasFactory;
    protected $table = 'sales';

    protected $fillable = [
        'id_user',
        'month',
        'value',
        'quantity',
        'name',
        'description'
    ];
}
