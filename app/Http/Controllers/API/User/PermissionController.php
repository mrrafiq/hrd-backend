<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;
use F9Web\ApiResponseHelpers;

class PermissionController extends Controller
{
    use ApiResponseHelpers;

    public function index()
    {
        $data = Permission::query();
        return DataTables::eloquent($data)->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $permission = new Permission;
            $permission->name = $request->name;
            $permission->guard_name = $request->guard_name;
            $permission->save();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
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
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function show(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $permission = Permission::find($request->id);
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess($permission);
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
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function showRole(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $permission = Permission::find($request->id);
            $roles = $permission->roles;
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess($roles);
    }
}
