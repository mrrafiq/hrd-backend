<?php

namespace App\Http\Controllers\API\Position;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Position\JobTitle;
use Yajra\DataTables\Facades\DataTables;
use F9Web\ApiResponseHelpers;

class JobTitleController extends Controller
{
    use ApiResponseHelpers;

    public function index() :JsonResponse
    {
        $data = JobTitle::query();
        return DataTables::eloquent($data)->toJson();
    }

    public function store(Request $request) :JsonResponse
    {
        $request->validate([
            'name' => 'required',
            // 'department_id' => 'required',
            'parents' => 'array'
        ]);

        try {
            $job_title = new JobTitle;
            $job_title->name = $request->name;
            $job_title->description = $request->description;
            $job_title->department_id = $request->department_id;
            $job_title->parents = json_encode($request->parents);
            $job_title->children = $request->children;
            $job_title->save();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function update(Request $request) :JsonResponse
    {
        $request->validate([
            'id' => 'required',
            'name' => 'required',
            // 'department_id' => 'required',
            // 'parents' => 'array'
        ]);

        try {
            $job_title = JobTitle::find($request->id);
            $job_title->name = $request->name;
            $job_title->description = $request?->description;
            $job_title->department_id = $request->department_id;
            $job_title->parents = $request->parents;
            $job_title->children = $request->children;
            $job_title->save();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess();
    }

    public function show(Request $request): JsonResponse
    {
        $data = JobTitle::find($request->id);
        if (!$data) {
            return $this->respondNotFound("Job title not found");
        }

        $parents = json_decode($data->parents);
        $get_parents = JobTitle::whereIn('id', $parents)->get();
        $data->parents = $get_parents;

        $children = json_decode($data->children);
        $get_children = JobTitle::whereIn('id', $children)->get();
        $data->children = $get_children;

        $getPositions = JobTitle::getPositions($request->id);
        $data->parents = $getPositions->parents;
        $data->children = $getPositions->children;
        
        return $this->respondWithSuccess($data);
    }

    public function destroy(Request $request): JsonResponse
    {
        try {
            $job_title = JobTitle::find($request->id);
            $job_title->delete();
        } catch (\Throwable $th) {
            return $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess([
            "message" => "Job title deleted successfully"
        ]);
    }
}
