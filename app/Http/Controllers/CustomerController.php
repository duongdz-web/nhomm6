<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('khachhang as kh')
            ->leftJoin('dondathang as dh', 'kh.maKH', '=', 'dh.maKH')
            ->leftJoin('chitietdondat as ct', 'dh.maDH', '=', 'ct.maDH')
            ->select(
                'kh.maKH',
                'kh.tenKH',
                DB::raw('MAX(dh.ngayLap) as last_order_date'),
                DB::raw('COUNT(DISTINCT dh.maDH) as donhangs_count'),
                DB::raw('SUM(ct.soLuong) as tong_soluong'),
                DB::raw('SUM(ct.giaBan) as tong_tien')
            )
            ->groupBy('kh.maKH', 'kh.tenKH');
    
        // Lọc theo mã KH
        if ($request->filled('maKH')) {
            $query->where('kh.maKH', 'like', '%' . $request->maKH . '%');
        }
    
        // Lọc theo tên KH
        if ($request->filled('tenKH')) {
            $query->where('kh.tenKH', 'like', '%' . $request->tenKH . '%');
        }
    
        $customers = $query->get();
    
        // Gán cấp độ & kiểm tra thời gian mua hàng
        $customers = $customers->map(function ($cus) {
            $tong = $cus->tong_tien ?? 0;
            if ($tong >= 15000000) $cus->cap_do = 'Kim Cương';
            elseif ($tong >= 7000000) $cus->cap_do = 'Vàng';
            elseif ($tong >= 3000000) $cus->cap_do = 'Bạc';
            elseif ($tong >= 500000) $cus->cap_do = 'Thành viên';
            else $cus->cap_do = 'Chưa phân loại';
    
            $cus->last_order_date = $cus->last_order_date ? Carbon::parse($cus->last_order_date) : null;
            return $cus;
        });
    
        // Lọc theo cấp độ
        if ($request->filled('level')) {
            $customers = $customers->filter(function ($cus) use ($request) {
                return $cus->cap_do === $request->level;
            });
        }
    
        // Lọc theo “mua thường xuyên” hoặc “lâu chưa mua”
        if ($request->filled('filter')) {
            if ($request->filter == 'frequent') {
                $customers = $customers->filter(function ($cus) {
                    return $cus->last_order_date && $cus->last_order_date->greaterThanOrEqualTo(Carbon::now()->subDays(30)) && $cus->donhangs_count >= 2;
                });
            } elseif ($request->filter == 'inactive') {
                $customers = $customers->filter(function ($cus) {
                    return !$cus->last_order_date || $cus->last_order_date->lessThan(Carbon::now()->subDays(60));
                });
            }
        }
    
        return view('store.khachhang', ['customers' => $customers]);
    }
    
}
