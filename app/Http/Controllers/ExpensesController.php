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

        if ($month = $request->input('month')) {
            $query->where('month', 'like', "%{$month}%");
        }

        $expenses = $query->get();

        return response()->json([
            'expenses' => $expenses,
            'status'   => count($expenses) ? 'success' : 'error',
            'message'  => count($expenses)
                ? 'Gastos carregados com sucesso'
                : 'Error ao carregar os gastos',
            'code'     => count($expenses) ? 200 : 422,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month'            => 'required|string',
            'expenses_current' => 'required|numeric',
        ]);

        $existing = Expenses::where('month', $validated['month'])->first();

        if ($existing) {
            $existing->expenses_current += $validated['expenses_current'];
            $existing->expenses_next = $existing->expenses_current;
            $existing->save();

            return response()->json([
                'expenses' => $existing,
                'status'   => 'success',
                'message'  => 'Gastos atualizados com sucesso',
                'code'     => 200,
            ]);
        }

        $previous = Expenses::where(
            'month',
            now()->parse($validated['month'])->subMonth()->format('F')
        )->first();

        $new = Expenses::create([
            'month'             => $validated['month'],
            'expenses_current'  => $validated['expenses_current'],
            'expenses_previous' => $previous?->expenses_current,
            'expenses_next'     => $validated['expenses_current'],
        ]);

        if ($previous) {
            $previous->expenses_next = $validated['expenses_current'];
            $previous->save();
        }

        return response()->json([
            'expenses' => $new,
            'status'   => 'success',
            'message'  => 'Gastos adicionados com sucesso',
            'code'     => 200,
        ]);
    }

    public function destroy($id)
    {
        $expense = Expenses::find($id);

        if (! $expense) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gasto não encontrado',
                'code'    => 404,
            ], 404);
        }

        $expense->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Gasto removido com sucesso',
            'code'    => 200,
        ], 200);
    }
}
