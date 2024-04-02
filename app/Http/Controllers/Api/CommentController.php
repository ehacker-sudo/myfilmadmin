<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Film;
use App\Models\Rate;
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
    public function comment(Request $request)
    {
        $input = $request->all();
        $comments = Comment::query();
        $tmdb_reviews = [];
        $isExist = false;
        
        if (isset($input["film_id"]) && isset($input["media_type"])) {
            if ($input["media_type"] == "episode") {
            } else {
                foreach (Comment::all() as $value) {
                    if ($value->film()->where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }
            }
        }
        
        if ($isExist) {
            $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();
            $comments->where("film_id", $film->_id);
            foreach ($comments->get() as $key => $value) {
                $tmdb_reviews = Arr::prepend($tmdb_reviews, [
                    "author" => $value->user->name,
                    "author_details" => [
                        "name" =>  $value->user->name,
                        "username" =>  $value->user->name,
                        "avatar_path" => null,
                        "rating" => Rate::where("user_id",$value->user_id)->where("film_id",$value->film_id)->exists() ? (double)Rate::where("user_id",$value->user_id)->where("film_id",$value->film_id)->first()->rate + 0.1 : null,
                    ],
                    "content" => $value->content,
                    "created_at" => $value->created_at,
                    // "created_at": "2015-02-23T11:11:56.401Z",
                    // "id": "54eb0afcc3a36836d90062eb",
                    // "updated_at": "2021-06-23T15:57:32.442Z",
                    // "url": "https://www.themoviedb.org/review/54eb0afcc3a36836d90062eb"
                ]);
            }
        }
        return response()->json([
            "results" => $tmdb_reviews
        ]);
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
        $input = $request->all();
        $rates = $request->user()->comments;

        $isExist = false;
        if ($input["media_type"] == "episode") {
        } else {
            foreach ($rates as $value) {
                if ($value->film()->where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                    $isExist = true;
                }
            }
        }

        if (isset($input["content"])) {
            return response()->json(collect([])->merge([
                "content" => $input["content"]
            ]), 200);
        }

        if ($isExist) {
            $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();
            $user_content = collect([])->merge([
                "film_id" => $film->film_id,
                "content" => Comment::where("film_id", $film->_id)->first()->content,
                "results" => collect($film)->except("film_id")->merge(["id" => $film->film_id]),
            ]);
            return response()->json($user_content);
        } else {
            return response()->error("Người dùng chưa bình luận phim này");
        }
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function comment_update(Request $request)
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
            $request->user()->comments()->where("film_id", $film->_id)->update([
                "content" => $input["content"]
            ]);
        }

        return response()->json([
            "content" => $input["content"]
        ], 202);
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
