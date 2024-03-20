<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Districts;
use App\Models\Provinces;
use App\Models\Wards;


class Address extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $province = api_address("mc-provinces", 1)->data;
        foreach ($province as $key => $value) {
            Provinces::query()->insert([
                'id' => $value->id ?? '',
                'name' => $value->name ?? '',
                'lat' => $value->lat ?? '',
                'lng' => $value->lng ?? '',
            ]);
        }

        for ($i = 1; $i <= 8; $i++) {
            $district = api_address('mc-districts', $i)->data;
            foreach ($district as $key => $value) {
                Districts::query()->insert([
                    'id' => $value->id ?? '',
                    'name' => $value->name ?? '',
                    'mc_province_id' => $value->mc_province_id ?? ''
                ]);
            }
        }
        
        for ($i = 1; $i <= 30; $i++) {
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
    }

}
