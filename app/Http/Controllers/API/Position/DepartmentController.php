<?php

namespace App\Http\Controllers\API\Position;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position\Department;
use App\Helpers\ApiResponse;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $data = Department::query();
        return DataTables::eloquent($data)->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            $department = new Department;
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();
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
            $department = Department::find($request->id);
            $department->name = $request->name;
            $department->description = $request->description;
            $department->save();
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
            $department = Department::find($request->id);
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::onlyEntity($department);
    }

    public function destroy(Request $request)
    {
        $department = Department::find($request->id);
        if (!$department) {
            return ApiResponse::failed('Department not found');
        }
        $department->delete();
        return ApiResponse::success();
    }
}
