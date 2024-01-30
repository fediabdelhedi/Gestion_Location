<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nom' => 'required',
            'prenom' => 'required',
             'telephone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6'
        ]);
    
        $user = User::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'telephone' => $request->telephone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'type' => 0, // Par défaut, un utilisateur a le type 0
        ]);
    
        $token = $user->createToken('token-name')->plainTextToken;
    
        return response()->json([
            'status' => true,
            'message' => 'User Created Successfully',
            'token' => $token,
            'type' => $user->type, // Ajoutez le type de l'utilisateur à la réponse
        ], 200);
    }
    

}
