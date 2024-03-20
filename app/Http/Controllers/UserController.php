<?php

namespace App\Http\Controllers;

use App\Models\Sanctum\PersonalAccessToken;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liệt kê danh sách tài khoản Admin
     *
     * @return \Illuminate\View\View
     */

    public function user_list()
    {
        $user = User::all();
        $role = [
            "1" => "Quản trị hệ thống",
            "2" => "Member"
        ];
        return view('management.user', compact('user', "role"));
    }

    /**
     * Liệt kê danh sách Api Token
     *
     * @return \Illuminate\View\View
     */

    public function apiKey()
    {
        $keyapi = PersonalAccessToken::all();
        return view('management.apiKey', compact('keyapi'));
    }


    /**
     * Tạo 1 url post lưu thông tin tài khoản admin theo user_id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function select_user_id(Request $request)
    {
        $URL_EDIT_USER = route('manager.edit.user', ['user' => $request->user_id]);
        $user = User::find($request->user_id);
        return [
            "url" => $URL_EDIT_USER,
            'name' => $user->name,
        ];
    }

    /**
     * Sửa thông tin tài khoản Admin
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function edit_user(User $user, Request $request)
    {
        $new_info = [];
        if (isset($request->new_name)) {
            $new_info['name'] = $request->new_name;
        }
        if (isset($request->new_role)) {
            $new_info['role'] = $request->new_role;
        }
        if (isset($request->new_email)) {
            $new_info['email'] = $request->new_email;
        }
        if (isset($request->new_password)) {
            $new_info['password'] = Hash::make($request->new_password);
        }
        if (isset($request->new_fullname)) {
            $new_info['fullname'] = $request->new_fullname;
        }
        $user->update($new_info);

        return back()->with('status', 'Cập nhật người dùng thành công');
    }

    /**
     * xác thực yêu cầu thêm mới người dùng
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function create_user_request(Request $request)
    {
        $input = $request->all();

        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:App\Models\User,email',
            'password' => 'required',
            'confirm_password' => 'required_with:password|same:password',
        ];

        $messages = [
            'unique' => ':attribute đã tồn tại',
            'same' => ':attribute và :other chưa khớp với nhau',
            'required_with' => 'Hãy nhập :attribute',
            'required' => 'Hãy nhập :attribute',
            'email' => 'Hãy nhập đúng định dạng :attribute',
        ];

        // Manually Creating Validators...
        $validator = Validator::make($input, $rules, $messages, [
            'name' => 'tên đăng nhập',
            'email' => 'địa chỉ email',
            'password' => 'mật khẩu',
            'confirm_password' => 'mật khẩu xác thực',
        ]);

        if ($validator->fails()) {
            $textError = [
                'name' => $validator->errors()->first('name') ?? '',
                'email' => $validator->errors()->first('email') ?? '',
                'password' => $validator->errors()->first('password') ?? '',
                'confirm_password' => $validator->errors()->first('confirm_password') ?? '',
            ];
            return response()->error($textError);
        }

        return response()->success();
    }

    /**
     * Tạo 1 tài khoản admin mới
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function create_user(Request $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'role' => $request->role
        ]);

        return back()->with('status', 'Tạo mới người dùng thành công');
    }


    /**
     * Xóa 1 tài khoản admin
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete_user(User $user)
    {
        $user->delete();
        return back();
    }

    /**
     * Tạo 1 Persional Access Token mới
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function create_token(Request $request)
    {
        $token = [];
        if (isset($request->unit_name)) {
            $token['name'] = $request->unit_name;
        }
        if (isset($request->api_token)) {
            $plainTextToken = $request->api_token;
            $token['token'] = hash('sha256', $plainTextToken);
        }
        if (isset($request->state)) {
            if ($request->state == "1") {
                $token['abilities'] = "activate";
            } else if ($request->state == "2") {
                $token['abilities'] = "unactivate";
            }
        }
        if (isset($request->api_name)) {
            $token['api_name']= $request->api_name;
        }
        if (isset($request->apitoken)) {
            $token['api_token']= $request->apitoken;
        }
        $request->user()->tokens()->create($token);


        return back()->with('status', 'Tạo mới Key Api thành công');
    }

    /**
     * xác thực yêu cầu thêm mới người dùng
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function create_token_request(Request $request)
    {
        $input = $request->all();

        $rules = [
            'unit_name' => 'required',
            'api_token' => 'required',
        ];

        $messages = [
            'required' => 'Hãy nhập :attribute',
        ];

        // Manually Creating Validators...
        $validator = Validator::make($input, $rules, $messages, [
            'unit_name' => 'tên đơn vị',
            'api_token' => 'Api Key Token',
        ]);

        if ($validator->fails()) {
            $textError = [
                'unit_name' => $validator->errors()->first('unit_name') ?? '',
                'api_token' => $validator->errors()->first('api_token') ?? ''
            ];

            return response()->error($textError);
        }

        return response()->success();
    }

    /**
     * Tạo 1 chuỗi plainTextToken
     *
     * @return array
     */

    public function create_personal_access_token()
    {
        $plainTextToken = Str::random(40);
        $token = $plainTextToken;
        return response()->json([
            'token' => $token
        ]);
    }

    /**
     * Tạo 1 url post lưu thông tin api token theo key_id
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function select_key_id(Request $request)
    {
        $URL_EDIT_KEY = route('manager.edit.token', ['token' => $request->key_id]);
        $token =  $request->user()->tokens()->where('_id', $request->key_id)->first();
        return response()->json([
            "url" => $URL_EDIT_KEY,
            "unit_name" => $token->name,
            "api_name" => $token->api_name,
            "api_token" => $token->api_token,
        ]);
    }

    /**
     * Sửa thông tin tài khoản Admin
     *
     * @param  \App\Models\Sanctum\PersonalAccessToken  $token
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function edit_token(PersonalAccessToken $token, Request $request)
    {
        if (isset($request->unit_new_name)) {
            $new_token['name'] = $request->unit_new_name;
        }
        if (isset($request->new_api_token)) {
            $plainTextToken = $request->new_api_token;
            $new_token['token'] = hash('sha256', $plainTextToken);
        }
        if (isset($request->new_state)) {
            if ($request->new_state == "1") {
                $new_token['abilities'] = "activate";
            } else if ($request->new_state == "2") {
                $new_token['abilities'] = "unactivate";
            }
        }
        if (isset($request->api_new_name)) {
            $token['api_name']= $request->api_new_name;
        }
        if (isset($request->apinew_token)) {
            $token['api_token']= $request->apinew_token;
        }
        $token->update($new_token);

        return back()->with('status', 'Cập nhật key Api thành công');
    }

    /**
     * Xóa 1 tài khoản admin
     *
     * @param  \App\Models\Sanctum\PersonalAccessToken  $token
     * @return \Illuminate\Http\RedirectResponse
     */

    public function delete_token(PersonalAccessToken $token)
    {
        $token->delete();
        return back();
    }
}
