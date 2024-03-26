<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Film;
use App\Models\History;
use App\Models\Rate;
use App\Models\WatchList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }


            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_comment(Request $request)
    {
        $comments = $request->user()->comments;
        return response()->json($comments);
    }
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment_store(Request $request)
    {
        $input = $request->all();
        $rules = [
             'film_id' => 'required',
             'season_id' => 'required_if:media_type,episode',
             'episode_id' => 'required_if:media_type,episode',
             'content' => 'required',
             'media_type' => 'required',
             'user_id' => 'required',
         ];
 
         $messages = [
             'unique' => ':attribute đã tồn tại',
             'same' => ':attribute và :other chưa khớp với nhau',
             'required_with' => 'Hãy nhập :attribute',
             'required' => 'Hãy nhập :attribute',
             'required_if' => 'Hãy nhập :attribute',
         ];
 
         // Manually Creating Validators...
         $validator = Validator::make($input, $rules, $messages, [
            //  'name' => 'tên đăng nhập',
            //  'email' => 'địa chỉ email',
            //  'password' => 'mật khẩu',
            //  'confirm_password' => 'mật khẩu xác thực',
         ]);
          
         if ($validator->fails()) {
             $textError = [
                 'film_id' => $validator->errors()->first('film_id') ?? '',
                 'season_id' => $validator->errors()->first('season_id') ?? '',
                 'episode_id' => $validator->errors()->first('episode_id') ?? '',
                 'content' => $validator->errors()->first('content') ?? '',
                 'media_type' => $validator->errors()->first('media_type') ?? '',
                 'user_id' => $validator->errors()->first('user_id') ?? '',
             ];
             return response()->error($textError);
         }
 
         if ($input["media_type"] == "episode") {
            if (Comment::where("film_id",$input["film_id"])->where("season_id",$input["season_id"])->where("episode_id",$input["episode_id"])->where("media_type",$input["media_type"])->exists()) {
                $textError = [
                    'episode_id' => "Mã tập đã tồn tại",
                ];
                return response()->error($textError);
            }
         }
         else{
            if (Comment::where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
                $textError = [
                    'film_id' => "Mã phim đã tồn tại",
                ];
                return response()->error($textError);
            }
         }

         $comment = Arr::except($request->all(), ['_token']);
         $comment["created_at"] = Carbon::now()->toDateTimeString();
         $comment["updated_at"] = Carbon::now()->toDateTimeString();
         Comment::query()->insert($comment);
 
         return response()->success();
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function comment_destroy(Comment $comment)
    {
        $comment->delete();
        return response()->success();
    }

            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        $histories = History::all();
        return response()->json($histories);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_history(Request $request)
    {
        $historys = $request->user()->histories;
        return response()->json($historys);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history_store(Request $request)
    {
        $input = $request->all();
        // $rules = [
        //      'film_id' => 'required_if:media_type,episode,tv,movie',
        //      'season_id' => 'required_if:media_type,episode',
        //      'episode_id' => 'required_if:media_type,episode',
        //      'person_id' => 'required_if:media_type,person',
        //      'media_type' => 'required',
        //      'user_id' => 'required',
        //  ];
 
        //  $messages = [
        //      'unique' => ':attribute đã tồn tại',
        //      'same' => ':attribute và :other chưa khớp với nhau',
        //      'required_with' => 'Hãy nhập :attribute',
        //      'required' => 'Hãy nhập :attribute',
        //      'required_if' => 'Hãy nhập :attribute',
        //      'email' => 'Hãy nhập đúng định dạng :attribute',
        //  ];
 
        //  // Manually Creating Validators...
        //  $validator = Validator::make($input, $rules, $messages, [
        //     //  'name' => 'tên đăng nhập',
        //     //  'email' => 'địa chỉ email',
        //     //  'password' => 'mật khẩu',
        //     //  'confirm_password' => 'mật khẩu xác thực',
        //  ]);
          
        //  if ($validator->fails()) {
        //      $textError = [
        //          'film_id' => $validator->errors()->first('film_id') ?? '',
        //          'season_id' => $validator->errors()->first('season_id') ?? '',
        //          'episode_id' => $validator->errors()->first('episode_id') ?? '',
        //          'media_type' => $validator->errors()->first('media_type') ?? '',
        //          'person_id' => $validator->errors()->first('person_id') ?? '',
        //          'user_id' => $validator->errors()->first('user_id') ?? '',
        //      ];
        //      return response()->error($textError);
        //  }
 
        //  if ($input["media_type"] == "episode") {
        //     if (History::where("film_id",$input["film_id"])->where("season_id",$input["season_id"])->where("episode_id",$input["episode_id"])->where("media_type",$input["media_type"])->exists()) {
        //         $textError = [
        //             'episode_id' => "Mã tập đã tồn tại",
        //         ];
        //         return response()->error($textError);
        //     }
        //  }
        //  elseif ($input["media_type"] == "person") {
        //     if (History::where("person_id",$input["person_id"])->where("media_type",$input["media_type"])->exists()) {
        //         $textError = [
        //             'person_id' => "Mã diễn viên đã tồn tại",
        //         ];
        //         return response()->error($textError);
        //     }
        //  }
        //  else{
        //     if (History::where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
        //         $textError = [
        //             'film_id' => "Mã phim đã tồn tại",
        //         ];
        //         return response()->error($textError);
        //     }
        //  }

         $rate = Arr::except($request->all(), ['_token']);
         $rate["created_at"] = Carbon::now()->toDateTimeString();
         $rate["updated_at"] = Carbon::now()->toDateTimeString();
         History::query()->insert($rate);
 
         return response()->success();
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function history_destroy(History $history)
    {
        $history->delete();
        return response()->success();
    }

    
                /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate()
    {
        $rates = Rate::all();
        return response()->json($rates);
    }


            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_rate(Request $request)
    {
        $rates = $request->user()->rates;
        return response()->json($rates);
    }
            /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate_store(Request $request)
    {
        $input = $request->all();
        $rules = [
            'film_id' => 'required',
            'season_id' => 'required_if:media_type,episode',
            'episode_id' => 'required_if:media_type,episode',
            'media_type' => 'required',
            'rate' => 'required|numeric',
            'user_id' => 'required',
        ];
 
         $messages = [
             'unique' => ':attribute đã tồn tại',
             'same' => ':attribute và :other chưa khớp với nhau',
             'required_with' => 'Hãy nhập :attribute',
             'required' => 'Hãy nhập :attribute',
             'required_if' => 'Hãy nhập :attribute',
             'email' => 'Hãy nhập đúng định dạng :attribute',
         ];
 
         // Manually Creating Validators...
         $validator = Validator::make($input, $rules, $messages, [
            //  'name' => 'tên đăng nhập',
            //  'email' => 'địa chỉ email',
            //  'password' => 'mật khẩu',
            //  'confirm_password' => 'mật khẩu xác thực',
         ]);
          
         if ($validator->fails()) {
             $textError = [
                'film_id' => $validator->errors()->first('film_id') ?? '',
                'season_id' => $validator->errors()->first('season_id') ?? '',
                'episode_id' => $validator->errors()->first('episode_id') ?? '',
                'media_type' => $validator->errors()->first('media_type') ?? '',
                'rate' => $validator->errors()->first('rate') ?? '',
                'user_id' => $validator->errors()->first('user_id') ?? '',
             ];
             return response()->error($textError);
         }
 
         if ($input["media_type"] == "episode") {
            if (Rate::where("film_id",$input["film_id"])->where("season_id",$input["season_id"])->where("episode_id",$input["episode_id"])->where("media_type",$input["media_type"])->exists()) {
                $textError = [
                    'episode_id' => "Mã tập đã tồn tại",
                ];
                return response()->error($textError);
            }
         }
         else{
            if (Rate::where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
                $textError = [
                    'film_id' => "Mã phim đã tồn tại",
                ];
                return response()->error($textError);
            }
         }

         $rate = Arr::except($request->all(), ['_token']);
         $rate["created_at"] = Carbon::now()->toDateTimeString();
         $rate["updated_at"] = Carbon::now()->toDateTimeString();
         Rate::query()->insert($rate);
 

         return response()->success();
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function rate_destroy(Rate $rate)
    {
        $rate->delete();
        return response()->success();
    }
}
