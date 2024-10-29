<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\ApiResponse;

class TestController extends Controller
{
    public function test() {
        // Logic to test the API endpoint
        // For example, fetching data from a database, making API requests, or performing other operations

        // Return a success response with a message
        return ApiResponse::success('API endpoint test successful');
    }
}
