<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Đăng nhập lấy token vào Web Api bằng email và mật khẩu
     *
     * @param  \Illuminate\Http\Request  $request
     */

    public function login(Request $request)
    {
        if (isset($request->email)) {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                if (Hash::check($request->password, $user->password)) {
    
                    $tokenResult = $user->createToken('Personal Access Token', ['server:update']);
                    return response()->json([
                        'result' => true,
                        'message' => 'Đã đăng nhập thành công',
                        'status' => 2,
                        'access_token' => $tokenResult->plainTextToken,
                        'token_type' => 'Bearer',
                        'expires_at' => Carbon::parse(
                            $tokenResult->accessToken->expires_at
                        )->toDateTimeString(),
                        'user' => [
                            'id'    => $user->id,
                            'name'  => $user->name,
                            'email' => $user->email,
                        ]
                    ]);
                } else {
                    return response()->json(['result' => false, 'message' => 'Tài khoản hoặc mật khẩu không đúng', 'user' => null], 401);
                }
            } else {
                return response()->json(['result' => false, 'message' => 'Không tìm thấy người dùng', 'status' => 0, 'user' => null], 401);
            }
        }
        else{
            return response()->json(['result' => false, 'message' => "OK", 'user' => null], 200);
        }
    }

    /**
     * Đăng kí tài khoản sở hữu api token
     *
     * @param  \Illuminate\Http\Requestt  $request
     */

    public function register(Request $request)
    {
        $input = $request->all();

        if (!isset($request->email)) {
            return response()->json(['result' => false, 'message' => "OK", 'user' => null], 200);
        }
        $rules = [
            'name' => 'required|string|max:255|unique:App\Models\User,name',
            'email' => 'required|string|email|max:255|unique:App\Models\User,email',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required_with:password|same:password',
        ];

        // Manually Creating Validators...
        $validator = Validator::make($input, $rules, $messages = [
            'required' => 'Hãy nhập :attribute',
            'string'   => ':attribute Phải là chuỗi',
            'same' => ':attribute và :other chưa khớp với nhau',
            'email'   => 'Hãy nhập đúng định dạng email',
            "unique" => ':attribute đã tồn tại',
            "min" => ":attribute phải có ít nhất :min kí tự",
            "max" => ":attribute phải có nhiều nhất :max kí tự"
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'result' => false,
                'message' => $errors->all()
            ],404);
        }
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'result' => true,
            'message' => 'Đăng ký thành công. Vui lòng đăng nhập vào tài khoản của bạn.',
            'user_id' => $user->id,
        ], 201);
    }
}
