<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goals extends Model
{
    /** @use HasFactory<\Database\Factories\GoalsFactory> */
    use HasFactory;
    protected $table = 'goals';
    protected $fillable = [
        'title',
        'description',
        'completed',
    ];
}
