<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\WorkExperience;
use App\Helpers\ApiResponse;

class WorkExperienceController extends Controller
{
    public function index(Request $request)
    {
        $data = WorkExperience::where('user_id', $request->user_id)->get();
        return ApiResponse::onlyEntity($data);
    }

    public function show(Request $request)
    {
        $data = WorkExperience::where('user_id', $request->user_id)->where('id', $request->id)->first();
        if (!$data) {
            return ApiResponse::failed('Work experience not found');
        }
        return ApiResponse::onlyEntity($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "company_name" => "required",
            "job_title" => "required",
            "join_date" => "required",
            "end_date" => "required",
        ]);

        try {
            $work_experience = new WorkExperience;
            $work_experience->user_id = $request->user_id;
            $work_experience->company_name = $request->company_name;
            $work_experience->job_title = $request->job_title;
            $work_experience->join_date = $request->join_date;
            $work_experience->end_date = $request->end_date;
            $work_experience->save();
            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required",
            "user_id" => "required",
            "company_name" => "required",
            "job_title" => "required",
            "join_date" => "required",
            "end_date" => "required",
        ]);

        try {
            $work_experience = WorkExperience::where('id', $request->id)->where('user_id', $request->user_id)->first();
            if (!$work_experience) {
                return ApiResponse::failed('Work experience not found');
            }
            $work_experience->user_id = $request->user_id;
            $work_experience->company_name = $request->company_name;
            $work_experience->job_title = $request->job_title;
            $work_experience->join_date = $request->join_date;
            $work_experience->end_date = $request->end_date;
            $work_experience->save();
            return ApiResponse::success();

        } catch (\Throwable $th) {
            return ApiResponse::failed($th);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            "id" => "required",
            "user_id" => "required",
        ]);

        try {
            $work_experience = WorkExperience::where('id', $request->id)->where('user_id', $request->user_id)->first();
            if (!$work_experience) {
                return ApiResponse::failed('Work experience not found');
            }
            $work_experience->delete();
            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th);
        }
    }
}
