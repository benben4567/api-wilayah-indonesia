<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProvinceController extends Controller
{
    public function search(Request $request)
    {
        if (! empty($request->id)) {
            // query
            $province = Province::where('id', $request->id)->first();
            if ($province) {
                return ResponseFormatter::success($province, 'Data provinsi ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data provinsi tidak ditemukan.', 404);

        } elseif (! empty($request->keyword)) {
            // query
            $province = Province::where('name', 'like', "%".$request->keyword."%")->orderBy('name')->get();
            if ($province->count() > 0) {
                return ResponseFormatter::success($province, 'Data provinsi ditemukan.', 200);
            }
            return ResponseFormatter::error(null, 'Data provinsi tidak ditemukan.', 404);
        } else {
            return ResponseFormatter::error(null, 'parameter salah', 422);
        }
    }
}
