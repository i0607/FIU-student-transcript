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
    public function profile(Request $request)
        {
            return response()->json($request->user());
        }

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:8|confirmed',
    ]);

    $user = $request->user();

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['message' => 'Current password is incorrect'], 403);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Password updated successfully']);
}

}