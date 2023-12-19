<?php

namespace App\Http\Controllers\API\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Helpers\ApiResponse;
use Spatie\FlareClient\Api;

class ContactsController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $employee_id = $request->employee_id;
        $data = Contact::where('employee_number', $employee_id)->paginate(20);
        return ApiResponse::success($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'contact_name' => 'required',
            'type' => 'required',
            'value' => 'required',
        ]);

        try {
            $contact = new Contact;
            $contact->employee_id = $request->employee_id;
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
            'employee_id' => 'required',
            'contact_name' => 'required',
            'type' => 'required',
            'value' => 'required',
            'id' => 'required',
        ]);

        try {
            $contact = Contact::findOrfail($request->id);
            $contact->employee_id = $request->employee_id;
            $contact->contact_name = $request->contact_name;
            $contact->type = $request->type;
            $contact->value = $request->value;
            $contact->save();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());
        }
        
        return ApiResponse::success();
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        try {
            $contact = Contact::findOrfail($request->id);
            $contact->delete();
        } catch (\Throwable $th) {
            return ApiResponse::failed($th->getMessage());

        }
        
        return ApiResponse::success();
    }
}
