<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\Contact;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;

class ContactsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $user_id = $request->user_id;
        $data = Contact::where('user_id', $user_id)->get();
        return ApiResponse::onlyEntity($data);
    }

    public function show(Request $request)
    {
        $contact = Contact::where('user_id', $request->user_id)->where('id', $request->id)->first();
        if (!$contact) {
            return ApiResponse::failed('Contact not found');
        }
        return ApiResponse::onlyEntity($contact);
    }

    public function store(Request $request)
    {
        $request->validate([
            "user_id" => "required",
            "contact_name" => "required",
            "type" => "required",
            "value" => "required",
        ]);

        // validate user_id
        $validate = User::find($request->user_id);
        if (!$validate) {
            return ApiResponse::failed('Invalid user_id');
        }

        try {
            $contact = new Contact;
            $contact->user_id = $request->user_id;
            $contact->contact_name = $request->contact_name;
            $contact->type = $request->type;
            $contact->value = $request->value;
            $contact->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
       return ApiResponse::success();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'user_id' => 'required',
            'contact_name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        try {
            $contact = Contact::where('user_id', $request->user_id)->where('id', $request->id)->first();
            $contact->contact_name = $request->contact_name;
            $contact->type = $request->type;
            $contact->value = $request->value;
            $contact->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function delete(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'user_id' => 'required',
        ]);

        try {
            $contact = Contact::where('user_id', $request->user_id)->where('id', $request->id)->first();
            $contact->delete();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());

        }
        
        return ApiResponse::success();
    }
}
