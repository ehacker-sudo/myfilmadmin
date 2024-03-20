<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medicine;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class DonThuoc extends Controller
{
    /**
     * Lấy đơn thuốc 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */

    public function tim_kiem(Request $request)
    {
        if ($request->user()->currentAccessToken()->abilities == "unactivate") {
            return response()->json([
                'data' => [],
                'success' => false,
                'status' => 404,
                'message' => 'Invalid Route'
            ]);
        }

        $input = $request->all();

        $rules = [
            'phone_number' => 'required|numeric',
        ];

        $messages = [
            'required' => 'Hãy nhập :attribute',
            'numeric'   => ':attribute phải là các con số',
        ];

        // Manually Creating Validators...
        $validator = Validator::make($input, $rules, $messages, [
            'phone_number' => 'Số điện thoại',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'error' => [
                    'phone' => [
                        $errors->first('phone_number')
                    ]
                ]
            ]);
        }

        // Retrieve the validated input...
        $validated = $validator->validated();

        $phone_number = $validated['phone_number'];

        if (Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->exists()) {
            $the_nearest_medicine = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->max('created_at');

            $diff_between_2_dates = now()->diffInSeconds($the_nearest_medicine);
            if ($diff_between_2_dates <= 1800) {
                $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                return $medicines;

            } else {
                $new_medicines = GetMedicineApi($phone_number);

                if (collect($new_medicines)->isNotEmpty()) {
                    storeMedicine($new_medicines);

                    $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                    return $medicines;
                } else {
                    $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                    return $medicines;
                }
            }
        } else {
            $new_medicines = GetMedicineApi($phone_number);

            if (collect($new_medicines)->isNotEmpty()) {
                storeMedicine($new_medicines);

                $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                return $medicines;
            } else {
                $medicines = Medicine::where('so_dien_thoai_nguoi_kham_benh', '=', $phone_number)->get();
                return $medicines;
            }
        }
    }
}
