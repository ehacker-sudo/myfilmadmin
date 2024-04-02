<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Film;
use App\Models\WatchList;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class WatchListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function watchlist()
    {
        $watchlists = WatchList::all();
        return response()->json($watchlists);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_watchlist(Request $request)
    {
        $watchlists = $request->user()->watchlists;
        $list_watchlist = [];
        foreach ($watchlists as $value) {
            $list_watchlist = Arr::prepend($list_watchlist, $value->film()->first()->toArray());
        }
        return response()->json([
            "results" => $list_watchlist
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

        $watchlists = $request->user()->watchlists;

        $isExist = false;
        if ($input["media_type"] == "episode") {
            if (isset($input["series_id"]) && isset($input["season_number"]) && isset($input["episode_number"]) && isset($input["media_type"])) {
                foreach ($watchlists as $value) {
                    if ($value->film()->where("film_id", (int)$input["series_id"])->where("season_number", (int)$input["season_number"])->where("episode_number", (int)$input["episode_number"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }                
            }
        } else {
            if (isset($input["film_id"]) && isset($input["media_type"])) {
                foreach ($watchlists as $value) {
                    if ($value->film()->where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }
            }
        }
        if ($isExist) {
            // dd($input["film_id"]);
            if ($input["media_type"] == "episode") {
                $film = Film::where("film_id", (int)$input["series_id"])->where("season_number", (int)$input["season_number"])->where("episode_number", (int)$input["episode_number"])->where("media_type", $input["media_type"])->first();

                return response()->json(collect($film)->except("film_id")->merge(["id" => $film->film_id]));
            } else {
                $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();

                return response()->json(collect($film)->except("film_id")->merge(["id" => $film->film_id]));
            }
            
        } else {
            return response()->error("Phim này chưa có trong danh sách xem của người dùng");
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function watchlist_store(Request $request)
    {
        $input = $request->all();
        // return $input;
        if ($input["media_type"] == "episode") {
            if (isset($input["series_id"]) && isset($input["season_number"]) && isset($input["episode_number"]) && isset($input["media_type"])) {
                $watchlists = $request->user()->watchlists;
                foreach ($watchlists as $value) {
                    if ($value->film()->where("film_id", $input["series_id"])
                        ->where("season_number", $input["season_number"])
                        ->where("episode_number", $input["episode_number"])
                        ->where("media_type", $input["media_type"])->exists()
                    ) {
                        return response()->error("Mã tập đã tồn tại");
                    }
                    $film = Film::where("film_id", $input["series_id"])
                        ->where("season_number", $input["season_number"])
                        ->where("episode_number", $input["episode_number"])
                        ->where("media_type", $input["media_type"]);
                    if ($film->doesntExist()) {
                        $input["created_at"] = Carbon::now()->toDateTimeString();
                        $input["updated_at"] = Carbon::now()->toDateTimeString();
                        $input["film_id"] = $input["series_id"];
                        Film::query()->insert($input);
                        $film = Film::where("film_id", $input["series_id"])
                                    ->where("season_number", $input["season_number"])
                                    ->where("episode_number", $input["episode_number"])
                                    ->where("media_type", $input["media_type"])->first();
                    } else {
                        $film = $film->first();
                    }
                }
            }
        } else {
            $watchlists = $request->user()->watchlists;
            foreach ($watchlists as $value) {
                if ($value->film()->where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                    return response()->error("Mã phim đã tồn tại");
                }
            }
            if (Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->doesntExist()) {
                $input["created_at"] = Carbon::now()->toDateTimeString();
                $input["updated_at"] = Carbon::now()->toDateTimeString();
                $film = Film::create($input);
            } else {
                $film = Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->first();
            }
        }

        $input["user_id"] = $request->user()->id;
        $watchlist = [
            "film_id" => $film->_id,
            "created_at" => Carbon::now()->toDateTimeString(),
            "updated_at" => Carbon::now()->toDateTimeString(),
            "user_id" => $request->user()->id,
        ];
        Watchlist::query()->insert($watchlist);

        return response()->success();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function watchlist_destroy(Request $request)
    {
        $input = $request->all();
        // return $input;
        $watchlists = $request->user()->watchlists;
        $isExist = false;
        if ($input["media_type"] == "episode") {
            if (isset($input["series_id"]) && isset($input["season_number"]) && isset($input["episode_number"]) && isset($input["media_type"])) {
                foreach ($watchlists as $value) {
                    if ($value->film()->where("film_id", $input["series_id"])->where("season_number", $input["season_number"])->where("episode_number", $input["episode_number"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }      
                $film = Film::where("film_id", $input["series_id"])
                            ->where("season_number", $input["season_number"])
                            ->where("episode_number", $input["episode_number"])
                            ->where("media_type", $input["media_type"])->first();          
            }
        } else {
            if (isset($input["film_id"]) && isset($input["media_type"])) {
                foreach ($watchlists as $value) {
                    if ($value->film()->where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }

                $film = Film::where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->first();
            }
        }
        if ($request->user()->watchlists()->where("film_id", $film->_id)->delete() && $isExist) {
            return response()->success(204);
        } else {
            return response()->error("Không thể xóa phim khỏi danh sách xem");
        }
    }
}
