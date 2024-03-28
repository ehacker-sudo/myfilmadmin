<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Rate extends Model
{
    use HasFactory;

    /**
     * Get the film for the blog post.
     */
    public function film()
    {
        return $this->belongsTo(Film::class,"film_id","_id");
    }
}
