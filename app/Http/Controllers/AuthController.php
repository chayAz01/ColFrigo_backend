<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function auth(Request $request)
    {
        $utilisateurs = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];

        if (Auth::attempt($utilisateurs, true)) {
            $user = auth()->user();
            $remember_token = $user->remember_token;
            $Utilisateur = Utilisateur::where('remember_token', $remember_token)->first();
            return response()->json($Utilisateur);
        } else {
            return 0;
        }
    }

    public function authByToken(Request $request)
    {
        $Utilisateur = Utilisateur::where('remember_token', $request->token)->first();
        return response()->json($Utilisateur);
    }
}
