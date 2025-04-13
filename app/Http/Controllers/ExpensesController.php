<?php

namespace App\Http\Controllers;

use App\Models\Expenses;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Expenses::query();

        $month = $request->input('month');

        if ($month) {
            $query->where('month', 'like', '%' . $month . '%');
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
        $validated = $request->validate([
            'month' => 'required|string',
            'expenses_current' => 'required|numeric',
        ]);
    
        $existingExpense = Expenses::where('month', $validated['month'])->first();
    
        if ($existingExpense) {
            $existingExpense->expenses_current += $validated['expenses_current'];
            $existingExpense->expenses_next = $existingExpense->expenses_current;
            $existingExpense->save();
    
            return response()->json([
                'expenses' => $existingExpense,
                'status'   => 'success',
                'message'  => 'Gastos atualizados com sucesso',
                'code'     => 200
            ]);
        }
    
        $month = $validated['month'];
        $previousExpense = Expenses::where('month', now()->parse($month)->subMonth()->format('F'))->first();
    
        $allProducts = Products::all();
        $expensesProducts = $allProducts->sum('price');
        $highestProduct = $allProducts->sortByDesc('price')->first();
        $lowestProduct  = $allProducts->sortBy('price')->first();
    
        $expenses = Expenses::create([
            'month'                    => $validated['month'],
            'expenses_current'         => $validated['expenses_current'],
            'expenses_previous'        => $previousExpense ? $previousExpense->expenses_current : null,
            'expenses_next'            => $validated['expenses_current'],
            'expenses_products'        => $expensesProducts,
            'highest_spending_product' => $highestProduct ? $highestProduct->name : null,
            'lowest_spending_product'  => $lowestProduct ? $lowestProduct->name : null
        ]);
    
        if ($previousExpense) {
            $previousExpense->expenses_next = $validated['expenses_current'];
            $previousExpense->save();
        }
    
        return response()->json([
            'expenses' => $expenses,
            'status'   => 'success',
            'message'  => 'Gastos adicionados com sucesso',
            'code'     => 200
        ]);
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
    public function destroy($id)
    {
        $expenses = Expenses::find($id);

        if (!$expenses) {
            return response()->json([
                'status'  => 'error',
                'code'    => 404,
                'message' => 'Gasto não encontrado'
            ], 404);
        }
    
        $expenses->delete();
    
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Gasto removido com sucesso'
        ], 200);
    }
}
