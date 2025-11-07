<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{

    function abrirLogin() {
        return view('auth.login');
    }

    function login(Request $request) {
        // accept either cpf or email as login identifier
        $request->validate([
            'password' => 'required',
        ]);

        $identifier = $request->input('cpf') ?? $request->input('email') ?? $request->input('login');
        if (!$identifier) {
            return view('errors.custom', ['message' => 'Informe CPF ou email para efetuar o login.']);
        }

        $credentials = [];
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $identifier;
        } else {
            $credentials['cpf'] = $identifier;
        }
        $credentials['password'] = $request->password;

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
           /*return response()->json([
            'ok'    => true,
            'token' => $token,
            'user'  => [
                'id'    => $user->id,
                'name'  => $user->name,
                'email' => $user->email,
                'cpf'   => $user->cpf,
            ],
           ]);*/
           return view('home.index', compact('user'));
        }

        return view('errors.custom', ['message' => 'Credenciais inválidas.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
