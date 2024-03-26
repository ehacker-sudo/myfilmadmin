<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Film extends Model
{
    use HasFactory;

        /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'film_id',
        "backdrop_path",
        "poster_path",
        'name',
        'media_type',
        'first_air_date',
        'title',
        'release_date',
        'created_at',
        'updated_at',
    ];
}
