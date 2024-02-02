<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,email',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->password = bcrypt($request->password);
        $user->save();

        return ApiResponse::success();
    }

    public function index(): JsonResponse
    {
        $data = User::query();
        return DataTables::eloquent($data->orderByDesc('created_at'))->toJson();
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);
        return ApiResponse::onlyEntity($user);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request->id;
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'email|required',
            ]);
    
            $user = User::find($id);
    
            if ($request->email != $user->email) {
                $request->validate([
                    'email' => 'unique:users,email',
                ]);
            }
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = strtolower($request->email);
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function assign_role(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required',
            'role_id' => 'required',
        ]);

        try {
            $user = User::find($request->user_id);
            $user->assignRole($request->role_id);
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }
}
