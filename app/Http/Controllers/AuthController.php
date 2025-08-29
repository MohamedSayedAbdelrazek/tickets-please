<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    use ApiResponses;
    public function login(LoginRequest $request) {
        return $this->ok([],$request->get('email'),200);
    }
    public function register(RegisterRequest $request) {
         return $this->ok([],$request->get('email'),200);
    }
}
