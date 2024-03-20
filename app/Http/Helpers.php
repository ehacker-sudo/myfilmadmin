<?php

use Carbon\Carbon;
use App\Models\Medicine;


// Lưu thông tin đơn thuốc vào mongo database

if (!function_exists('storeMedicine')) {
    function storeMedicine($don_thuoc)
    {
        foreach ($don_thuoc as $key => $value) {
            if (Medicine::where('ma_don_thuoc', '=', $value->ma_don_thuoc)->doesntExist()) {
                Medicine::query()->insert(
                    [
                        "ma_don_thuoc" => $value->ma_don_thuoc ?? null,
                        "ho_ten_benh_nhan" => $value->ho_ten_benh_nhan ?? null,
                        "ngay_sinh_benh_nhan" => $value->ngay_sinh_benh_nhan ?? null,
                        "hinh_thuc_dieu_tri" => $value->hinh_thuc_dieu_tri ?? null,
                        "dia_chi" => $value->dia_chi ?? null,
                        "gioi_tinh" => $value->gioi_tinh ?? null,
                        "so_dien_thoai_nguoi_kham_benh" => $value->so_dien_thoai_nguoi_kham_benh ?? null,
                        "can_nang" => $value->can_nang ?? null,
                        "thong_tin_don_thuoc" => $value->thong_tin_don_thuoc ?? null,
                        "chan_doan" => $value->chan_doan ?? null,
                        "ten_bac_si" => $value->ten_bac_si ?? null,
                        "ten_co_so_kham_chua_benh" => $value->ten_co_so_kham_chua_benh ?? null,
                        "dia_chi_co_so_kham_chua_benh" => $value->dia_chi_co_so_kham_chua_benh ?? null,
                        "ma_bao_hiem_co_so_kham_chua_benh" => $value->ma_bao_hiem_co_so_kham_chua_benh ?? null,
                        "so_dien_thoai" => $value->so_dien_thoai ?? null,
                        "ngay_gio_ke_don" => $value->ngay_gio_ke_don ?? null,
                        "created_at" => Carbon::now()->toDateTimeString(),
                        "updated_at" => Carbon::now()->toDateTimeString()
                    ]
                );
            }
        }
    }
}
// Lấy thông tin đơn thuốc từ đơn thuốc điên tử

if (!function_exists('GetMedicineApi')) {
    function GetMedicineApi($phone_number)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.donthuocquocgia.vn/api/v1/don-thuoc/tim-kiem?phone=$phone_number",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'app-name: meddcom',
                'app-key: eyJpc3MiOiJodHRwOi8vZG9udGh1b2NxdW9jZ2lhLnRlY2h0YWxrMjRoLmN'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $array = json_decode($response);
        return $array;
    }
}

// Lấy thành phố , tỉnh, huyện ,xã từ web ytebox

if (!function_exists('api_address')) {

    function api_address($where, $page)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://ytebox.vn/api/v2/$where?page=$page",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $array = json_decode($response);
        return $array;
    }
}