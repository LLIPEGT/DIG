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
        $data = Venda::with('user', 'produtos')->get();

        return view('venda.index', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $venda = new Venda();

        if (isset($venda)){
            $venda->user_id = Auth::user()->id;
            $venda->save();

            return redirect()->route('carrinho.show', $venda);;
        }
        return 'Error';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venda = Venda::with('user', 'produtos')->find($id);


        return view('venda.show', compact('venda'));
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

    public function confirmar($id) {
        $venda = Venda::findOrFail($id);

        return null;
    }

}
