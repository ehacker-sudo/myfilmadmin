<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Districts;

class Provinces extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    protected $collection = 'provinces';
    protected $connection = 'mongodb';

    public function get_district()
    {
        return $this->hasMany(Districts::class, 'mc_province_id');
    }
}
