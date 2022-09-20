<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegencyController extends Controller
{
    public function search(Request $request)
    {
        if (!empty($request->id)) {
            // query
            $regency = DB::table('regencies')
                ->select('regencies.id', 'regencies.name', 'provinces.id AS province_id', 'provinces.name AS province_name')
                ->join('provinces', 'provinces.id', '=', 'regencies.province_id')
                ->where('regencies.id', '=', $request->id)
                ->first();
            if ($regency) {
                return ResponseFormatter::success($regency, 'Data kota/kabupaten ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data kota/kabupaten tidak ditemukan.', 404);
        } elseif (!empty($request->keyword)) {
            // query
            $regency = Regency::where('name', 'like', "%" . $request->keyword . "%")->orderBy('name')->get();
            if ($regency->count() > 0) {
                return ResponseFormatter::success($regency, 'Data kota/kabupaten ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data kota/kabupaten tidak ditemukan.', 404);
        } elseif (!empty($request->province_id)) {
            // query
            $regency = Regency::where('province_id', $request->province_id)->orderBy('name')->get();
            if ($regency->count() > 0) {
                return ResponseFormatter::success($regency, 'Data kota/kabupaten ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data kota/kabupaten tidak ditemukan.', 404);
        } else {
            return ResponseFormatter::error(null, 'parameter salah', 422);
        }
    }
}
