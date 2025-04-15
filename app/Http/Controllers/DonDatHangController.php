<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\DonDatHang;
use App\Models\ChiTietDonDat;
use App\Models\SanPham;
use App\Models\ThongTinKH;
use App\Models\DanhGiaSanPham;
class DonDatHangController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user(); // Lấy người dùng đang đăng nhập

    // Bắt đầu truy vấn đơn hàng của user
    $query = DonDatHang::with('chitietdondat')
        ->where('maKH', $user->id)
        ->orderByDesc('ngayLap');

    // Nếu có truyền query ?tinhtrang=... thì lọc theo tình trạng
    if ($request->has('tinhtrang')) {
        $query->where('tinhTrang', $request->input('tinhtrang'));
    }

    // Lấy danh sách đơn hàng đã lọc
    $donDatHangs = $query->get();

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
    
        // Chỉ được phép hủy nếu tình trạng là "Chờ xử lý"
        if ($donDatHang->tinhTrang !== 'Chờ xử lý') {
            return redirect()->route('dondathang.index')->with('error', 'Chỉ có thể hủy đơn hàng khi đang ở trạng thái "Chờ xử lý".');
        }
    
        // Cập nhật tình trạng đơn hàng thành "Đã huỷ"
        $donDatHang->tinhTrang = 'Đã huỷ';
        $donDatHang->save();
    
        return redirect()->route('dondathang.index')->with('success', 'Đơn hàng đã được huỷ thành công.');
    
}
public function chinhsuathongtin()
{
    $user = Auth::user();
    $khachhang = ThongTinKH::where('maKH', $user->id)->firstOrFail();

    return view('dondathang.sua', compact('khachhang'));
}

public function capnhatthongtin(Request $request)
{
    $request->validate([
        'tenKH' => 'required|string|max:50',
        'gioiTinh' => 'required|boolean',
        'ngaySinh' => 'required|date',
        'diaChi' => 'required|string|max:150',
        'soDienThoai' => 'required|string|max:10',
    ]);

    $user = Auth::user();
    $khachhang = ThongTinKH::where('maKH', $user->id)->firstOrFail();

    $khachhang->update($request->only(['tenKH', 'gioiTinh', 'ngaySinh', 'diaChi', 'soDienThoai']));

    return redirect()->back()->with('success', 'Cập nhật thông tin thành công!');
}

public function hienThiFormDanhGia($maDH, $maSP)
{
    $chiTiet = \App\Models\ChiTietDonDat::where('maDH', $maDH)
    ->where('maSP', $maSP)
    ->firstOrFail();

// Tìm bản ghi đánh giá cho đơn hàng và sản phẩm cụ thể
$danhGia = \App\Models\DanhGiaSanPham::where('maDH', $maDH)
    ->where('maSP', $maSP)
    ->first();

// ✅ Kiểm tra nếu bản ghi không tồn tại hoặc nếu `soSao` hoặc `moTa` là null
$canDanhGia = !$danhGia || is_null($danhGia->soSao) || is_null($danhGia->moTa);

return view('dondathang.danhgia', [
'chiTiet' => $chiTiet,
'danhGia' => $danhGia,
'canDanhGia' => $canDanhGia
]);
}

// Xử lý lưu đánh giá
public function luuDanhGia(Request $request, $maDH, $maSP)
{
   
    $request->validate([
        'soSao' => 'required|integer|min:1|max:5',
        'moTa' => 'nullable|string|max:1000',
    ]);

    DanhGiaSanPham::updateOrCreate(
        ['maDH' => $maDH, 'maSP' => $maSP],
        ['soSao' => $request->soSao, 'moTa' => $request->moTa]
    );

    return redirect()->route('dondathang.chitiet', $maDH)->with('success', 'Đánh giá đã được lưu.');
}




}

