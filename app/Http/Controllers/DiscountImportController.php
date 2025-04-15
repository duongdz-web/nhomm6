<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
class DiscountImportController extends Controller
{

    

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $path = $request->file('file')->getRealPath();
        $data = Excel::toArray([], $request->file('file'))[0];

        // Bỏ qua dòng tiêu đề
        unset($data[0]);

        foreach ($data as $row) {
            $maKH = $row[0];
            $idMaGG = $row[1];

            if ($maKH && $idMaGG) {
                DB::table('discounts_kh')->updateOrInsert(
                    ['maKH' => $maKH, 'idMaGG' => $idMaGG],
                    ['maKH' => $maKH, 'idMaGG' => $idMaGG]
                );
            }
        }

        return back()->with('success', 'Đã nhập mã giảm giá thành công!');
    }
}


