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




    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'department' => 'nullable|string|max:255',
        'staffNumber' => 'nullable|string|max:255|unique:users', // Add unique validation
        'role' => 'nullable|string|in:admin,staff,user',
    ]);

    $user = User::create([
        'name' => $request->name,
        'surname' => $request->surname,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'department' => $request->department,
        'staffNumber' => $request->staffNumber,
        'role' => $request->role ?? 'user', // Default to 'user' if not provided
    ]);

    $token = $user->createToken('token')->plainTextToken;

    return response()->json([
        'user' => $user,
        'token' => $token
    ], 201);
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