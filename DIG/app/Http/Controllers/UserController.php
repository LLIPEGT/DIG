<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\View\Components\alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::all();

        return view('usuario.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = new User();

        return view('usuario.create', compact("user"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string|unique:users,cpf',
            'password' => 'required|string|min:6',
        ]);
        $user = new User();

        if(isset($user) && $request){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->cpf = $request->cpf;
            $user->password = Hash::make($request->password);
            if($user){
                $user->save();
            }


            return redirect()->route('usuario.index');
        }
        return "Error";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if (isset($user))  return view('usuario.show', compact('user'));;

        return "ERROR";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);


        if(isset($user)){
            return view('usuario.edit', compact('user'));
        }

        return "error";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if(isset($user)){
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('usuario.index');
        }

        return 'Error';
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);

        if($data->delete())
              return redirect()->route('usuario.index');

        return 'Error';
    }
}
