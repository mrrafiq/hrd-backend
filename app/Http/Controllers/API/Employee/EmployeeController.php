<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use F9Web\ApiResponseHelpers;
use Illuminate\Http\JsonResponse;
use App\Models\Employee\Employee;

class EmployeeController extends Controller
{
    use ApiResponseHelpers;

    public function index(): JsonResponse
    {
        $data = Employee::paginate(20);
        return $this->respondWithSuccess($data);
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
            $employee->save();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'date_of_birth' => 'required',
            'place_of_birth' => 'required',
            'address' => 'required',
            'id' => 'required',
        ]);

        try {
            $employee = Employee::findOrfail($request->id);
            $employee->phone_number = $request->phone_number;
            $employee->date_of_birth = $request->date_of_birth;
            $employee->place_of_birth = $request->place_of_birth;
            $employee->address = $request->address;
            $employee->save();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function destroy($id)
    {
        try {
            $employee = Employee::findOrfail($id);
            $employee->delete();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess([
            "message" => "Employee deleted successfully"
        ]);
    }

    public function show($id)
    {
        $data = Employee::find($id);
        if (!$data) {
            return $this->respondNotFound("Employee not found");
        }
        return $this->respondWithSuccess($data);
    }

}
