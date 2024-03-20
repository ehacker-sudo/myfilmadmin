<?php

namespace App\Http\Controllers;

use App\Http\Requests\PhoneRequest;
use App\Models\Districts;
use Illuminate\Http\Request;
use App\Models\Medicine;
use App\Models\Provinces;
use App\Models\Wards;
use Carbon\Carbon;
use Illuminate\Cache\RateLimiting\Limit;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Liệt kê danh sách đơn thuốc trong db
     *
     * @return \Illuminate\View\View
     */

    public function basic_table()
    {
        $ward = api_address('mc-wards', 1)->data;
        $district = api_address('mc-districts', 1)->data;
        $provinces = Provinces::all();
        $get_dulieu_db = Medicine::all();
        $thanhpho = null;
        $disable_district = 'disabled';
        $disable_ward = 'disabled';
        return view("table.list", compact('get_dulieu_db', 'ward', 'district', 'provinces', 'thanhpho', 'disable_district', 'disable_ward'));
    }


    /**
     * Form lấy đơn thuốc
     *
     * @return \Illuminate\View\View
     */

    public function data_table()
    {
        return view('table.data');
    }

    /**
     * Thực hiện lấy đơn thuốc
     * @param  \App\Http\Requests\PhoneRequest  $request
     * @return \Illuminate\View\View
     */

    public function getApi(PhoneRequest $request)
    {
        $validated = $request->validated();

        $phone_number = $validated['phone_number'];
        if (Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->exists()) {

            $the_nearest_medicine = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->max('created_at');

            $diff_between_2_dates = now()->diffInSeconds($the_nearest_medicine);

            if ($diff_between_2_dates <= 1800) {

                $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                return view("table.data", compact('medicines', 'phone_number'));
            } else {

                $new_medicines = GetMedicineApi($phone_number);
                if (collect($new_medicines)->isNotEmpty()) {

                    storeMedicine($new_medicines);
                    $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                    return view("table.data", compact('medicines', 'phone_number'));
                } else {
                    $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                    return view("table.data", compact('medicines', 'phone_number'));
                }
            }
        } else {
            $new_medicines = GetMedicineApi($phone_number);

            if (collect($new_medicines)->isNotEmpty()) {
                storeMedicine($new_medicines);

                $medicines = Medicine::query()->where("so_dien_thoai_nguoi_kham_benh", "=", $phone_number)->get();
                return view("table.data", compact('medicines', 'phone_number'));
            } else {
                $medicines = Medicine::query()->where("so_dien_thoai_nguoi_kham_benh", "=", $phone_number)->get();
                return view("table.data", compact('medicines', 'phone_number'));
            }
        }
    }

    public function address(Request $request)
    {
        $provinces = Provinces::all();
        $get_dulieu_db = Medicine::query();
        $quan = null;
        $phuongxa = null;
        $thanhpho = null;
        $list_quan = [];
        $list_phuongxa = [];
        $disable_district = '';
        $disable_ward = '';
        if (isset($request->province)) {
            $province_id = (int)$request->province;
            $province = Provinces::where('id', '=', $province_id)->first();
            $province_name = $province->name;
            foreach ($province->get_district as $key => $value) {
                $list_quan[$key]['id'] = $value->id;
                $list_quan[$key]['name'] = $value->name;
            }
            $get_dulieu_db = $get_dulieu_db->Where('dia_chi', 'LIKE', "%{$province_name}%");
            $thanhpho = $province_name;
            $disable_district = '';
            $disable_ward = 'disabled';
        } else {
            $disable_district = 'disabled';
            $disable_ward = 'disabled';
        }
        if (isset($request->district)) {
            $district_id = (int)$request->district;
            $district = Districts::query()->where('id', '=', $district_id)->first();
            $district_name = $district->name;
            foreach ($district->get_ward as $key => $value) {
                $list_phuongxa[$key]['id'] = $value->id;
                $list_phuongxa[$key]['name'] = $value->name;
            }
            $get_dulieu_db = $get_dulieu_db->Where('dia_chi', 'LIKE', "%{$district_name}%");
            $quan = $district_name;
            $disable_ward = '';
        } else {
            $disable_ward = 'disabled';
        }
        if (isset($request->ward)) {
            $ward = Wards::where('id', '=', (int)$request->ward)->first();
            $get_dulieu_db = $get_dulieu_db->Where('dia_chi', 'LIKE', "%{$ward->name}%");
            $phuongxa = $ward->name;
        }
        $get_dulieu_db = $get_dulieu_db->orderBy('created_at', 'desc')->get();
        return view("table.list", compact('get_dulieu_db', 'provinces', 'thanhpho', 'quan', 'phuongxa', 'disable_ward', 'disable_district', 'list_quan', 'list_phuongxa'));
    }

    public function details($id)
    {
        $get_dulieu_db = Medicine::query()->where("_id", "=", $id)->first();
        return view("table.detail", compact('get_dulieu_db'));
    }

    public function renderDitrict(Request $request)
    {
        $quan = [];
        if (!isset($request->type)) {
            return [
                'html' => '<select class="custom-select2 form-control" style="width: 100%; height: 38px" disabled ><option selected value="">Chọn quận/huyện...</option></select>',
                'html2' => '<select class="custom-select2 form-control" style="width: 100%; height: 38px"disabled ><option selected value="">Chọn phường/xã...</option></select>',
            ];
        }
        $province_id = (int)$request->type;
        $province = Provinces::where('id', '=', $province_id)->first();
        foreach ($province->get_district as $key => $value) {
            $quan[$key]['id'] = $value->id;
            $quan[$key]['name'] = $value->name;
        }
        $html = view('table.ajax._district', compact('quan'))->render();
        return [
            'html' => $html,
            'html2' => '<select class="custom-select2 form-control" style="width: 100%; height: 38px"disabled ><option selected value="">Chọn phường/xã...</option></select>',
        ];
    }

    public function renderWard(Request $request)
    {
        $phuongxa = [];
        if (!isset($request->type)) {
            return [
                'html' => '<select class="custom-select2 form-control" style="width: 100%; height: 38px" disabled ><option selected value="">Chọn quận/huyện...</option></select>',
                'html2' => '<select class="custom-select2 form-control" style="width: 100%; height: 38px"disabled ><option selected value="">Chọn phường/xã...</option></select>',
            ];
        }

        $district_id = (int)$request->type;
        $district = Districts::where('id', '=', $district_id)->first();
        foreach ($district->get_ward as $key => $value) {
            $phuongxa[$key]['id'] = $value->id;
            $phuongxa[$key]['name'] = $value->name;
        }
        $html = view('table.ajax._ward', compact('phuongxa'))->render();
        return [
            'html' => $html,
        ];
    }
}
