<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
use App\Models\Wards;

class Districts extends Model
{
    use HasFactory;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    
    protected $collection = 'districts';
    protected $connection = 'mongodb';

    public function get_ward()
    {
        return $this->hasMany(Wards::class, 'mc_district_id');
    }
}
