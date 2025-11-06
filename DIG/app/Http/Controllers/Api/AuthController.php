<?php

namespace App\Http\Controllers\API;

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
        $validated = $request->validate([
            'cpf' => 'required|string',
            'password' => 'required',
        ]);

        if(Auth::attempt($validated)) {
            $user = User::where('cpf', $validated['cpf'])->first();
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

        return "error 1";
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
