<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [
            'sales' => Sales::all(),
            'status' => 'success',
            'message' => 'Vendas carregados com sucesso',
            'code' => 200
        ];

        if(count($data['sales']) > 0){
            return response()->json($data, $data['code']);
        }

        return response()->json([
            'sales' => [],
            'status' => 'error',
            'message' => 'Nenhuma venda encontrada',
            'code' => 404
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|string',
            'value' => 'required|numeric',
            'quantity' => 'required|numeric',
            'name' => 'required|string',
            'description' => 'required|string',
        ]);

        $sales = Sales::create($validated);

        if(!$sales){
            return response()->json([
                'sales' => [],
                'status' => 'error',
                'message' => 'Erro ao criar venda',
                'code' => 422
            ], 422);
        } 

        return response()->json([
            'sales' => $sales,
            'status' => 'success',
            'message' => 'Vendas carregados com sucesso',
            'code' => 200
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $sales = Sales::find($id);

        if(!$sales){
            return response()->json([
                'status'  => 'error',
                'code'    => 404,
                'message' => 'Venda não encontrado'
            ], 404);
        }

        $sales->delete();

        return response()->json([
        'status'  => 'success',
        'code'    => 200,
        'message' => 'Venda removido com sucesso'
        ], 200);
   
    }
}