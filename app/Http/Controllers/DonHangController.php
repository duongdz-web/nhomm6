<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDat;
use App\Exports\DonHangExport;
use Maatwebsite\Excel\Facades\Excel;

class DonHangController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('dondathang')
            ->join('khachhang', 'dondathang.maKH', '=', 'khachhang.maKH')
            ->select(
                'dondathang.*',
                'khachhang.tenKH',
                'khachhang.diaChi'
            );

        if ($request->filled('maDH')) {
            $query->where('dondathang.maDH', 'like', '%' . $request->maDH . '%');
        }

        if ($request->filled('tinhTrang')) {
            $query->where('dondathang.tinhTrang', $request->tinhTrang);
        }

        if ($request->filled('TuNgay') && $request->filled('DenNgay')) {
            $query->whereBetween('dondathang.ngayLap', [$request->TuNgay, $request->DenNgay]);
        }

        $donhang = $query->orderBy('dondathang.ngayLap', 'desc')->get();

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
        return Excel::download(new DonHangExport, 'danh_sach_don_hang.xlsx');
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
