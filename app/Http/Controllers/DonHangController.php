<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDat;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('dondathang')
            ->join('khachhang', 'dondathang.maKH', '=', 'khachhang.id')
            ->select(
                'dondathang.*',
                'khachhang.tenKH',
                'khachhang.diaChi'
            );
    
        // Lọc theo mã đơn
        if ($request->filled('maDH')) {
            $query->where('dondathang.maDH', 'like', '%' . $request->maDH . '%');
        }
    
        // Lọc theo trạng thái
        if ($request->filled('tinhTrang')) {
            $query->where('dondathang.tinhTrang', $request->tinhTrang);
        }
    
        // Lọc theo ngày
        if ($request->filled('TuNgay') && $request->filled('DenNgay')) {
            $query->whereBetween('dondathang.ngayLap', [$request->TuNgay, $request->DenNgay]);
        }
    
        // Lấy dữ liệu đơn hàng
        $donhang = $query->orderBy('dondathang.ngayLap', 'desc')->get();
    
        // Gán thêm chi tiết từng đơn hàng
        foreach ($donhang as $dh) {
            $dh->chitiet = DB::table('chitietdondat')
                ->join('sanpham', 'chitietdondat.maSP', '=', 'sanpham.maSP')
                ->select('sanpham.tenSP', 'chitietdondat.soLuong', 'sanpham.giaBan')
                ->where('chitietdondat.maDH', $dh->maDH)
                ->get();
        }
    
        return view('store.donhang', compact('donhang'));
    }
    
public function export()
    {
        // Placeholder cho chức năng xuất file
        return response()->json(['message' => 'Chức năng export đang phát triển']);
    }
 public function updateTrangThai(Request $request, $maDH)
    {
        $request->validate([
            'tinhTrang' => 'required|string|max:50',
        ]);
    
        $donHang = DonDatHang::where('maDH', $maDH)->firstOrFail();
        $donHang->tinhTrang = $request->tinhTrang;
        $donHang->save();
    
        return redirect()->back()->with('success', 'Cập nhật trạng thái thành công!');
    }
        
}