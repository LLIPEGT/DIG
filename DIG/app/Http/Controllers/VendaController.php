<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use Illuminate\Http\Request;

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
        $venda = new Venda();

        if (isset($venda)){
            $venda->user_id = $request->user_id;
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
