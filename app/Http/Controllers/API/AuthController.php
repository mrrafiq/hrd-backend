<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;

class AuthController extends Controller
{    
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        if(Auth::attempt($request->only('email', 'password'))){
            $user = User::where('email', $request->email)->first();
            $token = $user->createToken('token')->plainTextToken;

            return ApiResponse::onlyEntity([
                'user' => $user,
                'token' => $token,
            ]);
        }
        
        return ApiResponse::failed('Invalid credentials');
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return ApiResponse::success('Logout successfully!');
    }

    public function me(): JsonResponse
    {
        $data = Auth::user();
        return ApiResponse::onlyEntity(['user' => $data])       ;
    }

    public function showUserPermissions(Request $request)
    {
        $user = User::find(Auth::user()->id);
        // get user roles
        $permissions = $user->getPermissionsViaRoles();
        $permissions = $permissions->map(function ($permission) {
            return $permission->name;
        });
        return ApiResponse::onlyEntity($permissions);
    }
}
