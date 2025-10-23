<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use App\Models\Produto;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Produto::with('marca')->get();

        return view('produto.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $produto = new Produto();
        $marca = Marca::all();

        if (isset($produto)) return view('produto.create', compact("produto", "marca"));

        return "Error";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $produto = new Produto();

        if(isset($produto)){
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->quantidade_estoque = $request->quantidade_estoque;
            $produto->marca_id = $request->marca_id;
            $produto->save();
            return redirect()->route('produto.index');
        }
        return "Error";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $produto = Produto::find($id);
        if(isset($produto)) return view('produto.show', compact('produto'));

        return 'Error';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $produto = Produto::find($id);
        $marca = Marca::all();

        if(isset($produto)) return view('produto.edit', compact('produto', 'marca'));

        return "ERROR";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $produto = Produto::find($id);

        if (isset($produto)) {
            $produto->nome = $request->nome;
            $produto->preco = $request->preco;
            $produto->quantidade_estoque = $request->quantidade_estoque;
            $produto->marca_id = $request->marca_id;
            $produto->save();
            return redirect()->route('produto.index');
        }

        return 'Error';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $produto = Produto::find($id);

        if($produto->delete()) return redirect()->route('produto.index');

        return 'Error';
    }
}
