<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $marca = Marca::all();

        return $marca;
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
        $marca = new Marca();

        if (isset($marca)){
            $marca->nome = $request->nome;
            $marca->save();
            return 'Marca criada';
        }

        return 'error';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $marca = Marca::find($id);

        if(isset($marca)) return $marca;

        return 'error';
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
        $marca = Marca::find($id);

        if(isset($marca)){
            $marca->nome = $request->nome;
            $marca->save();
            return 'Marca atualizada';
        }
        return 'Error';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marca = Marca::find($id);

        if($marca->delete()) return 'Marca deletada';

        return 'Error';
    }
}
