<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function __construct()
    {
        // Only allow admin to manage staff
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                return response()->json(['message' => 'Forbidden'], 403);
            }
            return $next($request);
        });
    }

    // List all staff
    public function index()
    {
        $staff = User::where('role', 'staff')->get();
        return response()->json($staff);
    }

    // Store a new staff member
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/', // must have letters and numbers
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'staffNumber' => 'required|string|max:50|unique:users,staffNumber',
        ]);

        $staff = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'staff', // Or you can allow dynamic role if needed
            'name' => $request->name,
            'surname' => $request->surname,
            'department' => $request->department,
            'staffNumber' => $request->staffNumber,
        ]);

        \Log::debug('API Store Hit');
        return response()->json(['message' => 'Staff created successfully', 'staff' => $staff], 201);
    }

    // Show a single staff member
    public function show($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        return response()->json($staff);
    }

    // Update a staff member
    public function update(Request $request, $id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);

        $request->validate([
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($staff->id)],
            'password' => ['nullable', 'min:8', 'regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/'],
            'name' => 'nullable|string|max:255',
            'surname' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'staffNumber' => ['nullable', 'string', Rule::unique('users', 'staffNumber')->ignore($staff->id)],
        ]);

        $staff->update([
            'email' => $request->email ?? $staff->email,
            'password' => $request->password ? Hash::make($request->password) : $staff->password,
            'name' => $request->name ?? $staff->name,
            'surname' => $request->surname ?? $staff->surname,
            'department' => $request->department ?? $staff->department,
            'staffNumber' => $request->staffNumber ?? $staff->staffNumber,
        ]);

        return response()->json(['message' => 'Staff updated successfully', 'staff' => $staff]);
    }

    // Delete a staff member
    public function destroy($id)
    {
        $staff = User::where('role', 'staff')->findOrFail($id);
        $staff->delete();

        return response()->json(['message' => 'Staff deleted successfully']);
    }
}
