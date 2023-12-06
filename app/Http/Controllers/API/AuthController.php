<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseHelpers;
    
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        if(Auth::attempt($request->only('email', 'password'))){
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token')->plainTextToken;

            return $this->respondWithSuccess([
                'token' => $token,
                'user' => $user,
            ]);
        }
        
        return $this->respondForbidden("Invalid credentials");
    }
}
