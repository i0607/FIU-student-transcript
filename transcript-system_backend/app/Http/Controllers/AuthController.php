<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        logger()->debug('Requested email: ' . $request->email);
        logger()->debug('Input password: ' . $request->password);
        logger()->debug('User found: ' . optional($user)->email);
        logger()->debug('Stored hash: ' . optional($user)->password);
        logger()->debug('Hash match: ' . (Hash::check($request->password, optional($user)->password) ? 'yes' : 'no'));
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    
        $token = $user->createToken('token')->plainTextToken;
    
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);

    }
}