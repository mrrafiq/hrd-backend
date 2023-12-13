<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use F9Web\ApiResponseHelpers;

class UserController extends Controller
{
    use ApiResponseHelpers;

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users,email',
            'password' => 'required',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = strtolower($request->email);
        $user->password = bcrypt($request->password);
        $user->save();

        return $this->respondCreated($user);
    }

    public function index(): JsonResponse
    {
        $data = User::paginate(20);
        return $this->respondWithSuccess($data);
    }

    public function show($id): JsonResponse
    {
        $user = User::find($id);
        return $this->respondWithSuccess($user);
    }

    public function update(Request $request): JsonResponse
    {
        $id = $request->id;
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'email|required',
            ]);
    
            $user = User::find($id);
    
            if ($request->email != $user->email) {
                dd("hello");
                $request->validate([
                    'email' => 'unique:users,email',
                ]);
            }
        } catch (\Throwable $th) {
            $this->respondError($th->getMessage());
        }
        
        try {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = strtolower($request->email);
            if ($request->password) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
        } catch (\Throwable $th) {
            $this->respondError($th->getMessage());
        }
        
        return $this->respondWithSuccess($user);
    }
}
