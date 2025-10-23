<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('home.index', compact('user'));
    }
}
