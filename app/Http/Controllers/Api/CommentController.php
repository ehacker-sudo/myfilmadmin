<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Film;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class CommentController extends Controller
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
        $list_comment = [];
        foreach ($comments as $value) {
            $list_comment = Arr::prepend($list_comment, $value->film()->first()->toArray());
        }
        return response()->json([
            "results" => $list_comment
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
    public function comment_store(Request $request)
    {
        $input = $request->all();
        if ($input["media_type"] == "episode") {
        }
        else{
            $comments = $request->user()->comments;
            foreach ($comments as $value) {
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
                $film = Arr::except($input, ['rate']);
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
            "content" => $input["content"],
            "user_id" => $request->user()->id,
        ];
        Comment::query()->insert($history);

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
}
