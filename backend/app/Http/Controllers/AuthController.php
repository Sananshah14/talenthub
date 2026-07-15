<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(RegisterRequest $request)
    {
        // $user = User::create([
        //     'name'=> $request->name,
        //     'email' => $request->email,
        //     'password' => $request->password,
        //     'role' => 'candidate',
        //     'status' => 'active',
        // ]);

        $data = $request->validated();
        $data['role'] = 'candidate';
        $data['status'] = 'active';
        $user = User::create($data);

        //create a token for a user
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
            'user' => $user,
            ], 201);
    }

    //Login
    public function login(LoginRequest $request)
    {
        $user = User::where('email',  $request->email )->first();

        if (! $user || ! Hash::check($request->password, $user->password))
        {
                throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
        'message' => 'Login successful.',
        'token' => $token,
        'user' => $user,
        ]);
    }

    //Logout, we are using Request class here, because logout doesn't need any validation.
    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }
}
