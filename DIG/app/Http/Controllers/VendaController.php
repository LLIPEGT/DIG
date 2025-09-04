<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venda = Venda::with('user')->get();

        return $venda;
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
        $request->validate([
            'quantidade_total' => 'required|numeric|min:0', // Garante que a quantidade seja válida
        ]);

        // Verifica se o usuário está autenticado
        if (!Auth::check()) {
            return response()->json(['message' => 'Usuário não autenticado'], 401); // Retorna erro se o usuário não estiver autenticado
        }

        $venda = new Venda();

        if (isset($venda)){
            $venda->user_id = Auth::user()->id;
            $venda->quantidade_total = $request->quantidade_total;
            $venda->save();

            return 'Venda criada';
        }
        return 'Error';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venda = Venda::find($id);

        if(isset($venda)) return $venda;

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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
