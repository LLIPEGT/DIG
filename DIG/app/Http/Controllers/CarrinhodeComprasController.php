<?php

namespace App\Http\Controllers;

use App\Models\CarrinhoDeCompras;
use App\Models\Venda;
use Illuminate\Http\Request;

class CarrinhodeComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carrinho = Venda::with('produtos')->get();

        return $carrinho;
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
    public function store(Request $request, string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $carrinho = Venda::with('produtos')->find($id);

        if(isset($carrinho)) return response()->json($carrinho);

        return "Error";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $validate = $request->validate([
            'produto_id' => 'required|exists:produtos,id',
        ]);

        $carrinho = Venda::find($id);

        if(isset($carrinho)) {
            
            $carrinho->produtos()->attach($request->produto_id);
            $carrinho->save();

            return 'item adicionado no carrinho de vendas';
        }

        return 'error';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

    }
}
