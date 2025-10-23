<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Marca::all();

        if(Auth::check() && Auth::user()){
            return view("marca.index", compact('data'));
        }
        return "ERROR";

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marca = new Marca();

        if(isset($marca)) return view('marca.create', compact('marca'));

        return "ERROR";
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
            return redirect()->route('marca.index');
        }

        return 'error';
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $marca = Marca::find($id);

        if(isset($marca)) return view('marca.show', compact('marca'));

        return "Error";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $marca = Marca::find($id);

        if(isset($marca)) return view('marca.edit', compact('marca'));

        return "ERROR";
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
            return redirect()->route('marca.index');
        }
        return 'Error';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $marca = Marca::find($id);

        if($marca->delete()) return redirect()->route('marca.index');

        return 'Error';
    }
}
