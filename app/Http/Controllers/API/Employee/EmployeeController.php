<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Models\Employee\Employee;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Controllers\API\Position\JobTitleController;

class EmployeeController extends Controller
{
    use ApiResponseHelpers;

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
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
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
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function destroy(Request $request)
    {
        try {
            $employee = Employee::findOrfail($request->id);
            $employee->delete();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess([
            "message" => "Employee deleted successfully"
        ]);
    }

    public function show(Request $request)
    {
        $data = Employee::find($request->id);
        $positions = Employee::getPositions($request->id);
        $data->positions = $positions;
        if (!$data) {
            return $this->respondNotFound("Employee not found");
        }
        return $this->respondWithSuccess($data);
    }

}
