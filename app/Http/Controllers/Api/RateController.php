<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class RateController extends Controller
{
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
        $list_rate = [];
        foreach ($rates as $value) {
            $list_rate = Arr::prepend($list_rate, $value->film()->first()->toArray());
        }
        return response()->json([
            "results" => $list_rate
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $rates = $request->user()->rates;
        $list_rate = [];
        foreach ($rates as $value) {
            $list_rate = Arr::prepend($list_rate, $value->film()->first()->toArray());
        }
        return response()->json([
            "results" => $list_rate
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate_store(Request $request)
    {
        $input = $request->all();
        if ($input["media_type"] == "episode") {
        }
        else{
            $histories = $request->user()->histories;
            foreach ($histories as $value) {
                if ($value->film()->where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
                    $textError = [
                        'film_id' => "Mã phim đã tồn tại. Không thể thêm vào lịch sử xem",
                    ];
                    return response()->error($textError);
                }
            }
            if (Film::where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->doesntExist()) {
                $input["created_at"] = Carbon::now()->toDateTimeString();
                $input["updated_at"] = Carbon::now()->toDateTimeString();
                $film = Film::create($input);
            }
            else {
                $film = Film::where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->first();
            }
        }
        $input["user_id"] = $request->user()->id;
        $rate = [
            "film_id" => $film->_id,
            "created_at" => Carbon::now()->toDateTimeString(),
            "updated_at" => Carbon::now()->toDateTimeString(),
            "rate" => $input["rate"],
            "user_id" => $request->user()->id,
        ];
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
