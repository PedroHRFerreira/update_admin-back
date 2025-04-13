<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('month');
            $table->float('expenses_current');
            $table->float('expenses_previous')->nullable();
            $table->float('expenses_next')->nullable();
            $table->float('expenses_products')->nullable();
            $table->string('highest_spending_product')->nullable();
            $table->string('lowest_cost_product')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
