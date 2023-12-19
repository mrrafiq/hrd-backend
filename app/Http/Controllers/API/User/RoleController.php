<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ApiResponse;

class RoleController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Role::query();
        return DataTables::eloquent($data)
        ->filter(function ($query) {
            if (request()->has('name')) {
                $query->where('name', 'like', "%" . request('name') . "%");
            }
        })
        ->toJson();
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            Role::create(['name' => $request->name]);
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        try {
            $role = Role::find($request->id);
            $role->name = $request->name;
            $role->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function show(Request $request): JsonResponse
    {
        $role = Role::find($request->id);
        if (!$role) {
            return ApiResponse::failed('Role not found');
        }
        return ApiResponse::onlyEntity($role);
    }

    public function destroy(Request $request): JsonResponse
    {
        $role = Role::find($request->id);
        if (!$role) {
            return ApiResponse::failed('Role not found');
        }
        $role->delete();
        return ApiResponse::success();
    }

    public function assignPermission(Request $request): JsonResponse
    {
        $request->validate([
            'role_id' => 'required',
            'permission_id' => 'array|required',
        ]);

        try {
            $role = Role::find($request->role_id);
            $role->givePermissionTo($request->permission_id);
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function showPermissions(Request $request): JsonResponse
    {
        $role = Role::find($request->id);
        if (!$role) {
            return ApiResponse::failed('Role not found');
        }
        $permissions = $role->permissions;

        return ApiResponse::onlyEntity(['permissions' => $permissions]);
    }
}
