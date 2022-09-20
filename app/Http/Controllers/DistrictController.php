<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistrictController extends Controller
{
    public function search(Request $request)
    {
        if (!empty($request->id)) {
            // query
            // $district = District::with('regency','province')->whereId($request->id)->first();
            $district = DB::table('districts')
                ->select('districts.id', 'districts.name', 'regencies.id AS regency_id', 'regencies.name as regency_name', 'provinces.id AS province_id', 'provinces.name as province_name')
                ->join('regencies', 'regencies.id', '=', 'districts.regency_id')
                ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
                ->where('districts.id', '=', $request->id)
                ->first();
            if ($district) {
                return ResponseFormatter::success($district, 'Data kecamatan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data kecamatan tidak ditemukan.', 404);
        } elseif (!empty($request->keyword)) {
            // query
            $district = District::where('name', 'like', "%" . $request->keyword . "%")->orderBy('name')->get();
            if ($district->count() > 0) {
                return ResponseFormatter::success($district, 'Data kecamatan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data kecamatan tidak ditemukan.', 404);
        } elseif (!empty($request->regency_id)) {
            // query
            $district = District::where('regency_id', $request->regency_id)->orderBy('name')->get();
            if ($district->count() > 0) {
                return ResponseFormatter::success($district, 'Data kecamatan ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data kecamatan tidak ditemukan.', 404);
        } else {
            return ResponseFormatter::error(null, 'parameter salah', 422);
        }
    }
}
