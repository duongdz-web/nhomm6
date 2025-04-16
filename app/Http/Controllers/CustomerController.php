<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Exports\CustomersExport;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
    
        // Truy vấn lấy danh sách khách hàng
        $query = DB::table('khachhang as kh')
            ->leftJoin('dondathang as dh', 'kh.id', '=', 'dh.maKH')
            ->leftJoin('chitietdondat as ct', 'dh.maDH', '=', 'ct.maDH')
            ->select(
                'kh.id',
                'kh.tenKH',
                'kh.diemTichLuy',
                DB::raw('MAX(dh.ngayLap) as last_order_date'),
                DB::raw('COUNT(DISTINCT dh.maDH) as donhangs_count'),
                DB::raw('SUM(ct.soLuong) as tong_soluong'),
                DB::raw('SUM(ct.giaBan) as tong_tien')
            )
            ->groupBy('kh.id', 'kh.tenKH', 'kh.diemTichLuy');

        // Lọc theo mã KH
        if ($request->filled('maKH')) {
            $query->where('kh.id', 'like', '%' . $request->maKH . '%');
        }

        // Lọc theo tên KH
        if ($request->filled('tenKH')) {
            $query->where('kh.tenKH', 'like', '%' . $request->tenKH . '%');
        }

        // Lấy dữ liệu khách hàng từ DB
        // Lấy dữ liệu khách hàng từ DB
$customers = $query->get();

// Lấy tất cả mã giảm giá
$magiamgias = DB::table('magiamgia')->get();

// Áp dụng các xử lý lên danh sách khách hàng
$customers = $customers->map(function ($cus) use ($magiamgias) {
    $tong = $cus->tong_tien ?? 0;

    // Lấy danh sách mã đã dùng từ bảng discounts_kh
    $maGGDaDung = DB::table('discounts_kh')
        ->where('maKH', $cus->id)
        ->pluck('idMaGG')
        ->toArray();

    // Cấp độ
    if ($tong >= 15000000) $cus->cap_do = 'Kim Cương';
    elseif ($tong >= 7000000) $cus->cap_do = 'Vàng';
    elseif ($tong >= 3000000) $cus->cap_do = 'Bạc';
    elseif ($tong >= 500000) $cus->cap_do = 'Thành viên';
    else $cus->cap_do = 'Chưa phân loại';

    // Không cần lọc theo điều kiện đơn hàng tối thiểu nữa
    $maGGsPhuHop = $magiamgias->filter(function ($mg) use ($maGGDaDung) {
        return !in_array($mg->maGG, $maGGDaDung);
    });

    $cus->maGiamGiasPhuHop = $maGGsPhuHop;

    // Mã tốt nhất
    $maTotNhat = $maGGsPhuHop->sortByDesc('dieuKienDonHangToiThieu')->first();
    $cus->maGiamGia = $maTotNhat->maGG ?? null;
    $cus->moTaMaGiamGia = $maTotNhat->moTaMaGiamGia ?? 'Không có';

    $cus->last_order_date = $cus->last_order_date ? \Carbon\Carbon::parse($cus->last_order_date) : null;

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

        // Trả về view với danh sách khách hàng
        return view('store.khachhang', ['customers' => $customers]);
    }

    public function export(Request $request)
    {
        try {
            session()->flash('success', 'File Excel danh sách khách hàng đã được xuất thành công!');
            $export = new CustomersExport();
            return Excel::download($export, 'danh_sach_khach_hang.xlsx');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')->with('error', 'Có lỗi xảy ra khi xuất file: ' . $e->getMessage());
        }
    }

}