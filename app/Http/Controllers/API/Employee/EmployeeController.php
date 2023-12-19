<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Models\Employee\Employee;
use Yajra\DataTables\Facades\DataTables;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function index()
    {
        $data = Employee::query();
        return DataTables::eloquent($data)
        ->filter(function ($query) {
            if (request()->has('employee_number')) {
                $query->where('employee_number', 'like', "%" . request('employee_number') . "%");
            }
            if (request()->has('job_title_id')) {
                $query->where('job_title_id', 'like', "%" . request('job_title_id') . "%");
            }
        })
        ->toJson();
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'phone_number' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'address' => 'required',
        ]);

        DB::beginTransaction();
        $employee_number = Employee::GenerateEmployeeNumber();

        try {
            $employee = new Employee;
            $employee->employee_number = $employee_number;
            $employee->user_id = $request->user_id;
            $employee->phone_number = $request->phone_number;
            $employee->date_of_birth = $request->date_of_birth;
            $employee->place_of_birth = $request->place_of_birth;
            $employee->address = $request->address;
            $employee->job_title_id = $request?->job_title_id;
            $employee->grade = $request?->grade;
            $employee->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        $give_permission = Employee::givePermission();
        if (!$give_permission) {
            return ApiResponse::failed('Failed to give permission');
        }
        DB::commit();
        return ApiResponse::success();
    }

    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'phone_number' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'address' => 'required',
            'id' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $employee = Employee::find($request->id);
            $employee->phone_number = $request->phone_number;
            $employee->date_of_birth = $request->date_of_birth;
            $employee->place_of_birth = $request->place_of_birth;
            $employee->address = $request->address;
            $employee->job_title_id = $request?->job_title_id;
            $employee->grade = $request?->grade;
            $employee->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        DB::commit();
        return ApiResponse::success();
    }

    public function destroy(Request $request)
    {
        try {
            $employee = Employee::findOrfail($request->id);
            $employee->delete();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function show(Request $request)
    {
        $data = Employee::with(['job_title', 'user'])->find($request->id);
        $job_title = Employee::getParentsChildren($request->id);
        // dd($positions);
        $data->job_title->parents = $job_title?->parents;
        $data->job_title->children = $job_title?->children;
        if (!$data) {
            return ApiResponse::failed('Employee not found');
        }
        return ApiResponse::onlyEntity($data);
    }

}
