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

        if ($input["media_type"] == "episode") {
            if (isset($input["series_id"]) && isset($input["season_number"]) && isset($input["episode_number"]) && isset($input["media_type"])) {
                foreach ($comments->get() as $value) {
                    if ($value->film()->where("film_id", (int)$input["series_id"])->where("season_number", (int)$input["season_number"])->where("episode_number", (int)$input["episode_number"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }
            }
        } else {
            if (isset($input["film_id"]) && isset($input["media_type"])) {
                foreach ($comments->get() as $value) {
                    if ($value->film()->where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }
            }
        }

        if ($isExist) {
            if ($input["media_type"] != "episode") {
                $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();
                $comments->where("film_id", $film->_id);
                foreach ($comments->get() as $key => $value) {
                    $tmdb_reviews = Arr::prepend($tmdb_reviews, [
                        "author" => $value->user->name,
                        "author_details" => [
                            "name" =>  $value->user->name,
                            "username" =>  $value->user->name,
                            "avatar_path" => null,
                            "rating" => Rate::where("user_id", $value->user_id)->where("film_id", $value->film_id)->exists() ? (float)Rate::where("user_id", $value->user_id)->where("film_id", $value->film_id)->first()->rate + 0.1 : null,
                        ],
                        "content" => $value->content,
                        "created_at" => $value->created_at,
                    ]);
                }
            } else {
                $film = Film::where("film_id", (int)$input["series_id"])->where("season_number", (int)$input["season_number"])->where("episode_number", (int)$input["episode_number"])->where("media_type", $input["media_type"])->first();
                $comments->where("film_id", $film->_id);
                foreach ($comments->get() as $key => $value) {
                    $tmdb_reviews = Arr::prepend($tmdb_reviews, [
                        "author" => $value->user->name,
                        "author_details" => [
                            "name" =>  $value->user->name,
                            "username" =>  $value->user->name,
                            "avatar_path" => null,
                            "rating" => Rate::where("user_id", $value->user_id)->where("film_id", $value->film_id)->exists() ? (float)Rate::where("user_id", $value->user_id)->where("film_id", $value->film_id)->first()->rate + 0.1 : null,
                        ],
                        "content" => $value->content,
                        "created_at" => $value->created_at,
                    ]);
                }
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
            if (isset($input["series_id"]) && isset($input["season_number"]) && isset($input["episode_number"]) && isset($input["media_type"])) {
                foreach ($rates as $value) {
                    if ($value->film()->where("film_id", (int)$input["series_id"])->where("season_number", (int)$input["season_number"])->where("episode_number", (int)$input["episode_number"])->where("media_type", $input["media_type"])->exists()) {
                        $isExist = true;
                    }
                }
            }
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
            if ($input["media_type"] == "episode") {
                $film = Film::where("film_id", (int)$input["series_id"])->where("season_number", (int)$input["season_number"])->where("episode_number", (int)$input["episode_number"])->where("media_type", $input["media_type"])->first();
            } else {
                $film = Film::where("film_id", (int)$input["film_id"])->where("media_type", $input["media_type"])->first();
            }

            return response()->json(collect($film)->except("film_id")->merge(
                [
                    "id" => $film->film_id,
                    "content" => Comment::where("film_id", $film->_id)->first()->content,
                ]
            ));
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
            if (isset($input["series_id"]) && isset($input["season_number"]) && isset($input["episode_number"]) && isset($input["media_type"])) {
                $comments = $request->user()->comments;
                foreach ($comments as $value) {
                    if ($value->film()->where("film_id", $input["series_id"])
                        ->where("season_number", $input["season_number"])
                        ->where("episode_number", $input["episode_number"])
                        ->where("media_type", $input["media_type"])
                        ->exists()
                    ) {
                        return response()->error("Mã tập đã tồn tại");
                    }
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
        } else {
            $comments = $request->user()->comments;
            foreach ($comments as $value) {
                if ($value->film()->where("film_id", $input["film_id"])->where("media_type", $input["media_type"])->exists()) {
                    $textError = [
                        'film_id' => "Mã phim đã tồn tại",
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
            $film = Film::where("film_id", $input["series_id"])
                ->where("season_number", $input["season_number"])
                ->where("episode_number", $input["episode_number"])
                ->where("media_type", $input["media_type"])->first();
            $request->user()->comments()->where("film_id", $film->_id)->update([
                "content" => $input["content"]
            ]);
        } else {
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
