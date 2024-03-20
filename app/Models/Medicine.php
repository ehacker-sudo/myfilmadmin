<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model;
// use Illuminate\Foundation\Testing\DatabaseMigrations;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Medicine extends Model
{
    use HasFactory;
    protected $collection = 'medicines';
    protected $connection = 'mongodb';
    protected $fillable = [
        'ma_don_thuoc',
        'ho_ten_benh_nhan',
        'ngay_sinh_benh_nhan',
        'hinh_thuc_dieu_tri',
        'dia_chi',
        'gioi_tinh',
        'so_dien_thoai_nguoi_kham_benh',
        'can_nang',
        'thong_tin_don_thuoc',
        'chan_doan',
        'ten_bac_si',
        'ten_co_so_kham_chua_benh',
        'dia_chi_co_so_kham_chua_benh',
        'ma_bao_hiem_co_so_kham_chua_benh',
        'so_dien_thoai',
        'ngay_gio_ke_don'
    ];
}
