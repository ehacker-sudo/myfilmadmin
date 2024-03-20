<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Carbon\Carbon;
use App\Models\Wards;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 31; $i <= 109; $i++) {
            $ward = api_address('mc-wards', $i)->data;
            if (isset($ward)) {
                foreach ($ward as $key => $value) {
                    Wards::query()->insert([
                        'id' => $value->id ?? '',
                        'name' => $value->name ?? '',
                        'mc_district_id' => $value->mc_district_id ?? ''
                    ]);
                }
            }
        }

        date_default_timezone_set("Asia/Ho_Chi_Minh");
        Medicine::query()->insert([
            [
                "ma_don_thuoc" => "00871GX18AH2-c",
                "ho_ten_benh_nhan" => "Nguyễn Hữu Trương",
                "ngay_sinh_benh_nhan" => "09/02/1975",
                "hinh_thuc_dieu_tri" => "ngoaitru",
                "dia_chi" => "Ấp Cây Hẹ- Phú Cần,  , Trà Vinh",
                "gioi_tinh" => "2",
                "so_dien_thoai_nguoi_kham_benh" => "0366794145",
                "can_nang" => 50,
                "ten_bac_si" => "BÁC SĨ TEST",
                "ten_co_so_kham_chua_benh" => "BỆNH VIỆN TEST",
                "dia_chi_co_so_kham_chua_benh" => "12 - Phường Mỹ Bình - Thành phố Long Xuyên - Tỉnh An Giang",
                "ma_bao_hiem_co_so_kham_chua_benh" => "00871",
                "so_dien_thoai" => "0263812133",
                "ngay_gio_ke_don" => "2022-05-04 09:30:59",
                "sold" => [],
                "thong_tin_don_thuoc" => [
                    [
                        "ma_thuoc" => "D0199002933",
                        "biet_duoc" => "Tranfaximox 500",
                        "ten_thuoc" => "Tranfaximox",
                        "don_vi_tinh" => "viên",
                        "cach_dung" => "Ngày uống 2 lần, mỗi lần 1 viên, sáng, chiều.",
                        "so_luong" => "4"
                    ],
                    [
                        "ma_thuoc" => "D0199002933",
                        "biet_duoc" => "Tranfaximox 500",
                        "ten_thuoc" => "Tranfaximox",
                        "don_vi_tinh" => "viên",
                        "cach_dung" => "Ngày uống 2 lần, mỗi lần 1 viên, sáng, chiều.",
                        "so_luong" => "4"
                    ]
                ],
                "chan_doan" => [
                    [
                        "ma_chan_doan" => "A00.1",
                        "ten_chan_doan" => "Đau lưng cấp",
                        "ket_luan" => "Đau lưng cấp"
                    ],
                    [
                        "ma_chan_doan" => "A00.1",
                        "ten_chan_doan" => "Đau lưng cấp",
                        "ket_luan" => "Đau lưng cấp"
                    ]
                ],
                "created_at" => Carbon::now("Asia/Ho_Chi_Minh")->toDateTimeString(),
                "updated_at" => Carbon::now("Asia/Ho_Chi_Minh")->toDateTimeString()
            ]
        ]);
    }

}
