<?php

namespace App\Http\Controllers;

use App\Models\User;
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

        $tipos = [
        (object) ['id' => 'cliente', 'label' => 'Cliente'],
        (object) ['id' => 'vendedor', 'label' => 'Vendedor'],
        (object) ['id' => 'admin', 'label' => 'Administrador'],
    ];

        return view('usuario.create', compact("user", 'tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'cpf'      => 'required|string|unique:users,cpf',
            'password' => 'required|string|min:6',
            'type'     => 'required|in:admin,vendedor,cliente',
        ]);

        $user = new User();

        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->cpf      = $request->cpf;
        $user->type     = $request->type;
        $user->password = Hash::make($request->password);

        $user->save();

        return redirect()->route('usuario.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);

        if ($user)
            return view('usuario.show', compact('user'));

        return view('errors.custom', ['message' => 'Usuário não encontrado.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

         $tipos = [
            (object) ['id' => 'cliente', 'label' => 'Cliente'],
            (object) ['id' => 'vendedor', 'label' => 'Vendedor'],
            (object) ['id' => 'admin', 'label' => 'Administrador'],
        ];

        if ($user)
            return view('usuario.edit', compact('user', 'tipos'));

        return view('errors.custom', ['message' => 'Usuário não encontrado para edição.']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (!$user)
            return view('errors.custom', ['message' => 'Erro ao atualizar usuário.']);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => "required|email|unique:users,email,$id",
            'cpf'   => "required|string|unique:users,cpf,$id",
            'type'  => 'required|in:admin,vendedor,cliente',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->cpf   = $request->cpf;
        $user->type  = $request->type;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('usuario.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = User::find($id);

        if ($data && $data->delete())
            return redirect()->route('usuario.index');

        return view('errors.custom', ['message' => 'Erro ao excluir usuário.']);
    }
}
