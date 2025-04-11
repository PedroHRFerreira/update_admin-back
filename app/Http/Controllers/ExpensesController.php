<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expenses::query();

        if ($request->has('expenses_current')) {
            $query->where('expenses_current', $request->expenses_current);
        }
    
        if ($request->has('highest_spending_product')) {
            $query->where('highest_spending_product', $request->highest_spending_product);
        }

        $expenses = $query->get();

        if(count($expenses) > 0)
        {
            return response()->json([
                'expenses' => $expenses,
                'status' => 'success',
                'message' => 'Gastos carregados com sucesso',
                'code' => 200
            ]);
        }

        return response()->json([
                'expenses' => [],
                'status' => 'Error',
                'message' => 'Error ao carregar os gastos',
                'code' => 422
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Expenses $expenses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Expenses $expenses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Expenses $expenses)
    {
        //
    }
}
