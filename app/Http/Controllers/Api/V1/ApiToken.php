<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;

class ApiToken extends Controller
{
    public function api_token(Request $request) {
        if ($request->user()->currentAccessToken()->abilities == "unactivate") {
            return response()->json([
                'data' => [],
                'success' => false,
                'status' => 404,
                'message' => 'Invalid Route'
            ]);
        }
        $rules = [
            'api_name' => 'required|string',
        ];
        
        $messages = [
            'required' => 'Hãy nhập api_name',
            'string'   => 'Api_name phải là chuỗi',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first('api_name')], 400);
        }


        $api_name = $request->input('api_name');
        $existingApiName = PersonalAccessToken::where('api_name', $api_name)->first();

        if ($existingApiName) {
            $Api_token = $existingApiName->api_token;
            return response()->json(['Api_name' => $api_name, 'Api_token' => $Api_token]);
        } else {
            return response()->json(['error' => 'Không tìm thấy api name'], 404);
        }
    }

    
}

