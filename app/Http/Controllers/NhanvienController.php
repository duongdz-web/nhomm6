<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\sanpham;
use Illuminate\Support\Facades\DB;

use App\Exports\SanPhamExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\SanPhamImport;

use App\Models\DonDatHang;


class NhanvienController extends Controller
{

    public function sanpham(Request $request)
    {
    $query = sanpham::query();

    if ($request->filled('maSP')) {
        $query->where('maSP', 'like', '%' . $request->maSP . '%');
    }

    if ($request->filled('tenSP')) {
        $query->where('tenSP', 'like', '%' . $request->tenSP . '%');
    }

    $sanpham = $query->get();

    return view("store.sanpham", compact('sanpham'));
    }
    
    public function edit($id)
    {
        $sanpham = sanpham::findOrFail($id);
        return view('store.sua-sanpham', compact('sanpham'));
    }

    public function destroy($id)
    {
        $sanpham = sanpham::findOrFail($id);
        $sanpham->delete();
        return redirect()->route('nhanvien.sanpham')->with('success', 'Đã xóa sản phẩm thành công!');
    }
    public function update(Request $request, $maSP)
    {
        $sp = sanpham::findOrFail($maSP);

        $sp->tenSP = $request->tenSP;
        $sp->giaNhap = $request->giaNhap;
        $sp->giaBan = $request->giaBan;
        $sp->soLuongTonKho = $request->soLuongTonKho;
        $sp->ngayNhap = $request->ngayNhap;
        $sp->donVi = $request->donVi;
        $sp->maLoai = $request->maLoai;

        // Nếu có hình ảnh mới
        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('sanpham'), $fileName);
            $sp->hinhanh = $fileName;
        }

        $sp->save();

        return redirect()->route('nhanvien.sanpham')->with('success', 'Cập nhật sản phẩm thành công!');
    }
    // Hiển thị form thêm sản phẩm
    public function create()
    {
        return view('store.them-sanpham');
    }

    // Lưu sản phẩm mới
    public function store(Request $request)
    {
        $request->validate([
            'maSP' => 'required|unique:sanpham',
            'tenSP' => 'required',
            'giaNhap' => 'required|numeric',
            'giaBan' => 'required|numeric',
            'soLuongTonKho' => 'required|numeric',
            'ngayNhap' => 'required|date',
            'donVi' => 'required',
            'maLoai' => 'required',
            'hinhanh' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('hinhanh')) {
            $file = $request->file('hinhanh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('sanpham'), $fileName);
            $data['hinhanh'] = $fileName;
        }

        sanpham::create($data);

        return redirect()->route('nhanvien.sanpham')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function doanhthu(Request $request)
    {
        $startDate = $request->input('start_date');  
        $endDate = $request->input('end_date');      
        $quarter = $request->input('quarter');
        $category = $request->input('category');
        $year = $request->input('year');

        // Danh sách các đơn hàng theo điều kiện lọc
        $donHangQuery = DB::table('dondathang')
            ->when($startDate, fn($q) => $q->whereDate('ngayLap', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('ngayLap', '<=', $endDate))
            ->when($quarter, fn($q) => $q->whereRaw('QUARTER(ngayLap) = ?', [$quarter]))
            ->when($year, fn($q) => $q->whereYear('ngayLap', $year));

        // Lọc theo loại sản phẩm
        if ($category) {
            $donHangQuery->whereIn('maDH', function ($sub) use ($category) {
                $sub->select('maDH')
                    ->from('chitietdondat')
                    ->join('sanpham', 'chitietdondat.maSP', '=', 'sanpham.maSP')
                    ->where('sanpham.maLoai', $category);
            });
        }

        // Lấy danh sách mã đơn hàng thỏa điều kiện
        $dsMaDH = $donHangQuery->pluck('maDH')->toArray();

        // Tổng doanh thu từ bảng dondathang (không nhân lên)
        $tongDoanhThu = DB::table('dondathang')
            ->whereIn('maDH', $dsMaDH)
            ->sum('tongTienThanhToan');

        // Tổng số lượng từ bảng chitietdondat
        $tongSoLuong = DB::table('chitietdondat')
            ->whereIn('maDH', $dsMaDH)
            ->sum('soLuong');

        // Doanh thu theo tháng
        $doanhThuThang = DB::table('dondathang')
            ->whereIn('maDH', $dsMaDH)
            ->select(DB::raw('MONTH(ngayLap) as thang'), DB::raw('SUM(tongTienThanhToan) as doanhthu'))
            ->groupBy('thang')
            ->pluck('doanhthu', 'thang')
            ->toArray();

        // Doanh thu theo quý
        $doanhThuQuy = DB::table('dondathang')
            ->whereIn('maDH', $dsMaDH)
            ->select(DB::raw('QUARTER(ngayLap) as quy'), DB::raw('SUM(tongTienThanhToan) as doanhthu'))
            ->groupBy('quy')
            ->pluck('doanhthu', 'quy')
            ->toArray();

        // Doanh thu theo loại sản phẩm
        $doanhThuLoai = DB::table('chitietdondat')
            ->join('dondathang', 'chitietdondat.maDH', '=', 'dondathang.maDH')
            ->join('sanpham', 'chitietdondat.maSP', '=', 'sanpham.maSP')
            ->join('loaisp', 'sanpham.maLoai', '=', 'loaisp.maLoai')
            ->select('loaisp.tenLoai as tenLoai', DB::raw('SUM(chitietdondat.soLuong * chitietdondat.giaBan) as doanhthu'))
            ->when($startDate, fn($q) => $q->whereDate('dondathang.ngayLap', '>=', $startDate))
            ->when($endDate, fn($q) => $q->whereDate('dondathang.ngayLap', '<=', $endDate))
            ->when($quarter, fn($q) => $q->whereRaw('QUARTER(dondathang.ngayLap) = ?', [$quarter]))
            ->when($category, fn($q) => $q->where('sanpham.maLoai', $category))
            ->when($year, fn($q) => $q->whereYear('dondathang.ngayLap', $year))
            ->groupBy('loaisp.tenLoai')
            ->pluck('doanhthu', 'tenLoai')
            ->toArray();        
        
        // Trạng thái đơn hàng
        $trangThaiDonHang = DonDatHang::whereIn('maDH', $dsMaDH)
            ->select('tinhTrang', DB::raw('count(*) as soLuong'))
            ->groupBy('tinhTrang')
            ->pluck('soLuong', 'tinhTrang')
            ->toArray();

        // Lấy danh sách loại sản phẩm
        $categories = DB::table('loaisp')->get();

        return view('nhanvien.doanhthu', compact(
            'tongDoanhThu', 'tongSoLuong',
            'doanhThuThang', 'doanhThuQuy', 'doanhThuLoai', 'trangThaiDonHang', 'categories'
        ));
    }
        public function export()
        {
            return Excel::download(new SanPhamExport, 'sanpham.xlsx');
        }
        
            public function import(Request $request)
        {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv'
            ]);

            Excel::import(new SanPhamImport, $request->file('file'));

            return redirect()->route('nhanvien.sanpham')->with('success', 'Import sản phẩm thành công!');
        }
}
