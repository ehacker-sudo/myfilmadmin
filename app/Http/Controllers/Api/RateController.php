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
        $input = $request->all();
        $rates = $request->user()->rates;

        $isExist = false;
        if ($input["media_type"] == "episode") {
        } else {
            foreach ($rates as $value) {
                if ($value->film()->where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                    $isExist = true;
                }
            }
        }
        if ($isExist) {
            $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();
            $user_rate = collect([])->merge([
                "film_id" => $film->film_id,
                "rate" => Rate::where("film_id", $film->_id)->first()->rate,
                "results" => collect($film)->except("film_id")->merge(["id" => $film->film_id]),
            ]);
            return response()->json($user_rate);
        } else {
            return response()->error("Người dùng chưa đánh giá phim này");
        }
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
        } else {
            $rates = $request->user()->rates;
            foreach ($rates as $value) {
                if ($value->film()->where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                    $textError = [
                        'film_id' => "Mã phim đã tồn tại. Không thể thêm đánh giá",
                    ];
                    return response()->error($textError);
                }
            }
            if (Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->doesntExist()) {
                $input["created_at"] = Carbon::now()->toDateTimeString();
                $input["updated_at"] = Carbon::now()->toDateTimeString();
                $film = Arr::except($input, ['rate']);
                $film = Film::create($input);
            } else {
                $film = Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->first();
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

        return response()->json([
            "rate" => $input["rate"],
        ],202);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rate_update(Request $request)
    {
        $input = $request->all();
        if ($input["media_type"] == "episode") {
        } else {
            // $rates = $request->user()->rates;
            // foreach ($rates as $value) {
            //     if ($value->film()->where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->exists()) {
            //         return response()->error("Mã phim đã tồn tại. Không thể thêm đánh giá");
            //     }
            // }
            // if (Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->doesntExist()) {
            //     $input["created_at"] = Carbon::now()->toDateTimeString();
            //     $input["updated_at"] = Carbon::now()->toDateTimeString();
            //     $film = Arr::except($input, ['rate']);
            //     $film = Film::create($input);
            // } else {
            //     $film = Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->first();
            // }
            $film = Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->first();
            $request->user()->rates()->where("film_id", $film->_id)->update([
                "rate" => $input["rate"]
            ]);
        }

        return response()->json([
            "rate" => $input["rate"]
        ],202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function rate_destroy(Request $request)
    {
        $input = $request->all();

        $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();
        $request->user()->watchlists()->where("film_id", $film->_id)->delete();

        return response()->success(204);
    }
}
