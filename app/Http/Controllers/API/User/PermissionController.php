<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;

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
            $permission->guard_name = $request->guard_name ?? 'api';
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
            $get_data = $permission?->roles;
            $roles = null;
            foreach ($get_data as $key => $value) {
                $roles[$key]['id'] = $value->id;
                $roles[$key]['name'] = $value->name;
                $roles[$key]['guard_name'] = $value->guard_name;
                $roles[$key]['created_at'] = $value->created_at;
                $roles[$key]['updated_at'] = $value->updated_at;
            }
            // dd($roles);
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::onlyEntity($roles);
    }

    /**
        * This function is used to assign multiple roles into a permission
        * params:
        * - id 
     */
    public function assignRolesToPermision(Request $request)
    {
        $request->validate([
            'permission_id' => 'required',
            'role_id' => 'array',
        ]);

        try {
            DB::beginTransaction();
            $permission = Permission::find($request->permission_id);
            $permission->roles()->sync($request->role_id);
            // dd("success");
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            return ApiResponse::failed($th->getMessage());
        }

        return ApiResponse::success();
    }
}
