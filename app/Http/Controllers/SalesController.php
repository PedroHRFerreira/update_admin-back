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
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        //
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