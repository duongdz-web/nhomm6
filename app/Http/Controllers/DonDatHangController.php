<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDat;
use App\Models\SanPham;
class DonDatHangController extends Controller
{
    public function index()
    {
        $user = Auth::user()    ; // lấy người dùng đang đăng nhập

        // Lấy các đơn hàng của user dựa trên id
        $donDatHangs = DonDatHang::with('chitietdondat')
            ->where('maKH', $user->id)
            ->orderByDesc('ngayLap')
            ->get();

        return view('dondathang.index', compact('donDatHangs'));
    }
    public function chitiet($id)
    {
        $user = Auth::user();
          // Chuyển đổi $user->id thành chuỗi
    
        // Lấy đơn đặt hàng của chính user đang đăng nhập và đúng mã đơn
        $dondathang = DonDatHang::with(['chitietdondat.sanpham'])
            ->where('maKH', $user->id)
            ->where('maDH', $id)
            ->firstOrFail();
            

        return view('dondathang.chitiet', compact('dondathang'));
    }
    public function huy($maDH)
{
    $user = Auth::user();

    // Tìm đơn đặt hàng theo ID và thuộc về user hiện tại
    $donDatHang = DonDatHang::where('maKH', $user->id)->where('maDH', $maDH)->firstOrFail();

    // Xóa các chi tiết đơn đặt hàng trước (nếu không có ràng buộc cascade)
    $donDatHang->chitietdondat()->delete();

    // Sau đó xóa đơn đặt hàng chính
    $donDatHang->delete();

    return redirect()->route('dondathang.index')->with('success', 'Đã hủy đơn hàng thành công.');
}
}
