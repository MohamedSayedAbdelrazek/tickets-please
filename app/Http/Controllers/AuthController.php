<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApiLoginRequest;
use App\Http\Requests\ApiRegisterRequest;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    //
    use ApiResponses;
    public function login(ApiLoginRequest $request) {
        return $this->ok([],$request->get('email'),200);
    }
    public function register(ApiRegisterRequest $request) {
         return $this->ok([],$request->get('email'),200);
    }
}
