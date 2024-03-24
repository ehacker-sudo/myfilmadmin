<?php

namespace App\Http\Controllers;

use App\Models\WatchList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

class WatchListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $watchlists = Watchlist::all();
        return view('management.watchlist', compact('watchlists'));
    }

        /**
     * xác thực yêu cầu thêm mới người dùng
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

     public function create_watchlist_request(Request $request)
     {
        $input = $request->all();
        $rules = [
             'film_id' => 'required',
             'season_id' => 'required_if:media_type,episode',
             'episode_id' => 'required_if:media_type,episode',
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
                 'media_type' => $validator->errors()->first('media_type') ?? '',
                 'user_id' => $validator->errors()->first('user_id') ?? '',
             ];
             return response()->error($textError);
         }
 
         if ($input["media_type"] == "episode") {
            if (WatchList::where("film_id",$input["film_id"])->where("season_id",$input["season_id"])->where("episode_id",$input["episode_id"])->where("media_type",$input["media_type"])->exists()) {
                $textError = [
                    'episode_id' => "Mã tập đã tồn tại",
                ];
                return response()->error($textError);
            }
         }
         else{
            if (WatchList::where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
                $textError = [
                    'film_id' => "Mã phim đã tồn tại",
                ];
                return response()->error($textError);
            }
         }

         return response()->success();
     }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $watchlist = Arr::except($request->all(), ['_token']);
        $watchlist["created_at"] = Carbon::now()->toDateTimeString();
        $watchlist["updated_at"] = Carbon::now()->toDateTimeString();
        WatchList::query()->insert($watchlist);

        return back()->with('status', 'Tạo mới đánh giá thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $URL_EDIT_RATE = route('manager.edit.history', ['history' => $request->history_id]);
        $watchlist = WatchList::find($request->rate_id);
        return [
            "url" => $URL_EDIT_RATE,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(WatchList $watchlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRateRequest  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WatchList $watchlist)
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
        if (isset($request->new_fullname)) {
            $new_info['fullname'] = $request->new_fullname;
        }
        $watchlist->update($new_info);

        return back()->with('status', 'Cập nhật người dùng thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(WatchList $watchlist)
    {
        $watchlist->delete();
        return back();
    }
}
