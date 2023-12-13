<?php

namespace App\Http\Controllers\API\Position;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Position\JobTitle;

class JobTitleController extends Controller
{
    public function index() :JsonResponse
    {
        $data = JobTitle::paginate(20);
        return $this->respondWithSuccess($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
        ]);

        try {
            $job_title = new JobTitle;
            $job_title->name = $request->name;
            $job_title->department_id = $request->department_id;
            $job_title->save();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }
}
