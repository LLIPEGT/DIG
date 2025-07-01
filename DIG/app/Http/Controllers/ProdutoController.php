<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produto = Produto::with('marca')->get();

        return $produto;
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
        $produto = new Produto();

        if(isset($produto)){
            $produto->nome = $request->nome;
            $produto->quantidadeKg = $request->quantidadeKg;
            $produto->marca_id = $request->marca_id;
            $produto->save();
            return "Produto criado";
        }
        return "Error";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Produto::find($id);
        if(isset($produto)) return $produto;

        return 'Error';
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
        $produto = Produto::find($id);

        if (isset($produto)) {
            $produto->nome = $request->nome;
            $produto->marca_id = $request->marca_id;
            $produto->save();
            return "Produto atualizado";
        }

        return 'Error';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Produto::find($id);

        if($produto->delete()) return 'Produto deletado';

        return 'Error';
    }
}
