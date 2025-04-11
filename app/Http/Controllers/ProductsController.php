<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;

class ProductsController extends Controller
{
    public function index(Request $request){
        $query = Products::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
    
        if ($request->has('price')) {
            $query->where('price', $request->price);
        }
    
        if ($request->has('quantity')) {
            $query->where('quantity', $request->quantity);
        }

        $products = $query->get();
        
        if(count($products) > 0){
            return response()->json([
                'products' => $products,
                'status' => 'success',
                'message' => 'Produtos carregados com sucesso',
                'code' => 200
            ]);
        }

        return response()->json([
            'products' => [],
            'status' => 'error',
            'message' => 'Nenhum produto encontrado',
            'code' => 404
        ]);
    }

    public function store(Request $request){

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric',
            'quantity'    => 'required|integer',
            'image'       => 'nullable|string'
        ]);

        $product = Products::create($validated);

        if($product) {
            return response()->json([
                'product' => $product,
                'status'  => 'success',
                'message' => 'Produto criado com sucesso',
                'code'    => 200
            ], 200);
        }

        return response()->json([
            'status'  => 'error',
            'code'    => 422,
            'message' => 'Falha ao criar o produto'
        ], 422);
    }

    public function destroy($id)
    {
        $product = Products::find($id);
    
        if (!$product) {
            return response()->json([
                'status'  => 'error',
                'code'    => 404,
                'message' => 'Produto não encontrado'
            ], 404);
        }
    
        $product->delete();
    
        return response()->json([
            'status'  => 'success',
            'code'    => 200,
            'message' => 'Produto removido com sucesso'
        ], 200);
    }
    
}
