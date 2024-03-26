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
    public function watchlist_store(Request $request)
    {
        $input = $request->all();
        if ($input["media_type"] == "episode") {
            // $watchlist = Watchlist::all();
            // foreach ($watchlist as $key => $value) {
                
            // }
            // $watchlist = Watchlist::query();
            // if (isset($input["film_id"])) {
            //     $watchlist = $watchlist->where("film_id",$input["film_id"]);
            // }
            // if (isset($input["season_id"])) {
            //     $watchlist = $watchlist->where("season_id",$input["season_id"]);
            // }
            // if (isset($input["episode_id"])) {
            //     $watchlist = $watchlist->where("episode_id",$input["episode_id"]);
            // }
            // if (isset($input["media_type"])) {
            //     $watchlist = $watchlist->where("media_type",$input["media_type"]);
            // }
            // if ($watchlist->exists()) {
            //     $textError = [
            //         'episode_id' => "Mã tập đã tồn tại",
            //     ];
            //     return response()->error($textError);
            // }
        }
         else{
            $watchlists = $request->user()->watchlists;
            $list_watchlist = [];
            foreach ($watchlists as $value) {
                if ($value->film()->where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
                    $textError = [
                        'film_id' => "Mã phim đã tồn tại",
                    ];
                    return response()->error($textError);
                }
            }
         }
        $input["created_at"] = Carbon::now()->toDateTimeString();
        $input["updated_at"] = Carbon::now()->toDateTimeString();
        $film = Film::create($input);
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
    public function watchlist_destroy(watchlist $watchlist)
    {
        $watchlist->delete();
        return response()->success();
    }
}
