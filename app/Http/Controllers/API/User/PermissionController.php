<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ApiResponse;

class PermissionController extends Controller
{
    public function index()
    {
        $data = Permission::get();
        return ApiResponse::onlyEntity($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'guard_name' => 'required'
        ]);

        try {
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
       return ApiResponse::success();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        try {
            $permission = Permission::find($request->id);
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
       return ApiResponse::success();
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $permission = Permission::find($request->id);
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::onlyEntity($permission);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $permission = Permission::find($request->id);
            $permission->delete();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
       return ApiResponse::success();
    }

    public function showRole(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $permission = Permission::find($request->id);
            $roles = $permission->roles->toArray();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::onlyEntity(['roles' => $roles]);
    }
}
