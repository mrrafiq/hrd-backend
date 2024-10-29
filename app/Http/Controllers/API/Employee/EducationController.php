<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee\Education;
use App\Helpers\ApiResponse;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $data = Education::where('user_id', $request->user_id)->get();
        return ApiResponse::onlyEntity($data);
    }

    public function show(Request $request)
    {
        $data = Education::where('user_id', $request->user_id)->where('id', $request->id)->first();
        if (!$data) {
            return ApiResponse::failed('Data not found');
        }
        return ApiResponse::onlyEntity($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            "user_id"       => "required",
            "school_name"   => "required",
            "degree"        => "required",
            "major"         => "string", // nullable
            "join_date"     => "required",
            "end_date"      => "required",
        ]);

        try {
            $education = new Education;
            $education->user_id       = $request->user_id;
            $education->school_name   = $request->school_name;
            $education->degree        = $request->degree;
            $education->major         = $request->major;
            $education->join_date     = $request->join_date;
            $education->end_date      = $request->end_date;
            $education->save();
            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            "id"            => "required",
            "user_id"       => "required",
            "school_name"   => "required",
            "degree"        => "required",
            "major"         => "string", // nullable
            "join_date"     => "required",
            "end_date"      => "required",
        ]);

        try {
            $education = Education::where('id', $request->id)->where('user_id', $request->user_id)->first();
            if (!$education) {
                return ApiResponse::failed('Data not found');
            }
            $education->user_id       = $request->user_id;
            $education->school_name   = $request->school_name;
            $education->degree        = $request->degree;
            $education->major         = $request->major;
            $education->join_date     = $request->join_date;
            $education->end_date      = $request->end_date;
            $education->save();
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
            $education = Education::where('id', $request->id)->where('user_id', $request->user_id)->first();
            if (!$education) {
                return ApiResponse::failed('Data not found');
            }
            $education->delete();
            return ApiResponse::success();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th);
        }
    }
}
