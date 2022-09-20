<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\District;
use App\Models\Province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VillageController extends Controller
{
    public function search(Request $request)
    {
        if (!empty($request->id)) {
            // query
            $village = DB::table('villages')
                ->select('villages.id', 'villages.name', 'villages.zip_code', 'districts.id AS district_id', 'districts.name AS district_name', 'regencies.id AS regency_id', 'regencies.name as regency_name', 'provinces.id AS province_id', 'provinces.name as province_name')
                ->join('districts', 'districts.id', '=', 'villages.district_id')
                ->join('regencies', 'regencies.id', '=', 'districts.regency_id')
                ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
                ->where('villages.id', '=', $request->id)
                ->first();
            if ($village) {
                return ResponseFormatter::success($village, 'Data desa/kelurahan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data desa/kelurahan tidak ditemukan.', 404);
        } elseif (!empty($request->keyword)) {
            // query
            $village = Village::where('name', 'like', "%" . $request->keyword . "%")->orderBy('name')->get();
            if ($village->count() > 0) {
                return ResponseFormatter::success($village, 'Data desa/kelurahan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data desa/kelurahan tidak ditemukan.', 404);
        } elseif (!empty($request->district_id)) {
            // query
            $village = Village::where('district_id', $request->district_id)->orderBy('name')->get();
            if ($village->count() > 0) {
                return ResponseFormatter::success($village, 'Data desa/kelurahan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data desa/kelurahan tidak ditemukan.', 404);
        } else {
            return ResponseFormatter::error(null, 'parameter salah', 422);
        }
    }

    public function zipcode($zipcode)
    {
        if (!empty($zipcode)) {
            $villages = Village::where('zip_code', $zipcode)->get();
            if ($villages->count() > 0) {
                $village = $villages->first();
                $district = District::where('id', $village->district_id)->first();
                $regency = Regency::where('id', $district->regency_id)->first();
                $province = Province::where('id', $regency->province_id)->first();

                return ResponseFormatter::success([
                    'desa_kelurahan' => $villages,
                    'kecamatan' => $district,
                    'kota_kabupaten' => $regency,
                    'provinsi' => $province
                ], 'Data desa/kelurahan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data desa/kelurahan tidak ditemukan.', 404);
        } else {
            return ResponseFormatter::error(null, 'parameter salah', 422);
        }
    }
}
