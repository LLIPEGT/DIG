<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    function register(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:11',
            'password' => 'required|min:6|confirmed',
        ]);

    }

    function login(Request $request) {
        $validated = $request->validate([
            'cpf' => 'required|string|max:11',
            'password' => 'required|min:6',
        ]);

        if(Auth::attempt($validated)) {
            $user = User::where('cpf', $validated['cpf'])->first();
            printf($user);
            $token = $user->createToken('api-token',  ['post:red', 'post:create'])->plainTextToken;

            return response()->json(['ok' => true, 'token' => $token]);
        }

        return "error";
    }

    function logout(Request $request){
        $token = $request->bearerToken();

        if(!$token){
            return response()->json(['ok' => false, 'msg' => 'Error, token não encontrado']);
        }

        $acess_token = PersonalAccessToken::findToken($token);

        if(!$acess_token){
            return response()->json(['ok' => false, 'msg' => 'Error, não tem um token de acesso']);
        }

        $acess_token->delete($token);

        return response()->json(['ok' => true, 'msg' => 'Token deletado', 'token' => $token]);

    }
}
