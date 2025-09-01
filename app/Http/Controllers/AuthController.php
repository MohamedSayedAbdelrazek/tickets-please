<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    use ApiResponses;
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            return $this->errorResponse('Invalid credentials', [], 401);

        $token = $user->createToken('api', [
            'tickets.read',
            'tickets.create',
            'tickets.update',
            'tickets.delete'
        ])->plainTextToken;

        return $this->ok([
            "user" => $user,
            "token" => $token,
            'token_type' => 'Bearer'
        ], "Logged in ✅", 200);

    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create([
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => Hash::make($data['password'])
        ]);

        $token=$user->createToken('api', [
            'tickets.read',
            'tickets.create',
            'tickets.update',
            'tickets.delete'
        ])->plainTextToken;

          return $this->ok([
            'user'  => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ], 'Registered successfully 🚀', 201);
    }

    public function me(Request $request) {
        return $this->ok(["user"=>$request->user()],"Current User",200);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
            return $this->ok([],"Logged out", 200);
    }

    public function logoutAll(Request $request) {
        $request->user()->tokens()->delete();
            return $this->ok([],'Logged out from all devices', 200);
    }
}
