<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Film;
use App\Models\History;
use App\Models\WatchList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class HistoryController extends Controller
{
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
        $histories = $request->user()->histories;
        $list_history = [];
        foreach ($histories as $value) {
            $list_history = Arr::prepend($list_history, $value->film()->first()->toArray());
        }
        return response()->json([
            "results" => $list_history
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $histories = $request->user()->histories;
        $list_history = [];
        foreach ($histories as $value) {
            $list_history = Arr::prepend($list_history, $value->film()->first()->toArray());
        }
        return response()->json([
            "results" => $list_history
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history_store(Request $request)
    {
        $input = $request->all();
        if ($input["media_type"] == "episode") {
        }
        else{
            $histories = $request->user()->histories;
            foreach ($histories as $value) {
                if ($value->film()->where("film_id",$input["film_id"])->where("media_type",$input["media_type"])->exists()) {
                    $textError = [
                        'film_id' => "Mã phim đã tồn tại",
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
        $history = [
            "film_id" => $film->_id,
            "created_at" => Carbon::now()->toDateTimeString(),
            "updated_at" => Carbon::now()->toDateTimeString(),
            "user_id" => $request->user()->id,
        ];
        if (History::query()->count() >= 10) {
            History::query()->skip(9)->delete();
        }
        History::query()->insert($history);

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
}
