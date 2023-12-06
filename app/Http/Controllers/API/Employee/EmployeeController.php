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

        try {
            $employee = new Employee;
            $employee->user_id = $request->user_id;
            $employee->phone_number = $request->phone_number;
            $employee->date_of_birth = $request->date_of_birth;
            $employee->place_of_birth = $request->place_of_birth;
            $employee->address = $request->address;
            $employee->save();
        } catch (\Throwable $th) {
            $this->respondInternalError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }
}
