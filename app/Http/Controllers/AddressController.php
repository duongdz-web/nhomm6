<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DiaChiGiaoHang;

class AddressController extends Controller
{
    public function danhsachdiachi()
    {
        $userId = Auth::id(); // Lấy mã khách hàng đang đăng nhập
        $addresses = DiaChiGiaoHang::where('maKH', $userId)
            ->orderByDesc('diaChiMacDinh')
            ->get();

        return view('addresses.danhsachdiachi', compact('addresses'));
    }

    public function updateDefault(Request $request)
    {
        $userId = Auth::id();
        $maDiaChi = $request->input('maDiaChi');

        // Reset địa chỉ mặc định
        DiaChiGiaoHang::where('maKH', $userId)->update(['diaChiMacDinh' => 0]);

        // Cập nhật địa chỉ mới làm mặc định
        $address = DiaChiGiaoHang::where('maKH', $userId)->where('maDiaChi', $maDiaChi)->first();
        if ($address) {
            $address->diaChiMacDinh = 1;
            $address->save();

            return response()->json(['success' => true, 'address' => $address]);
        }

        return response()->json(['success' => false]);
    }

    public function create()
    {
        return view('addresses.thongtindiachi', ['address' => new DiaChiGiaoHang(), 'isNew' => true]);
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id; // Lấy đúng kiểu chuỗi như 'KH0001'

        $request->validate([
            'hoTen' => 'required|string|max:255',
            'soDienThoai' => 'required|string|max:15',
            'diaChi' => 'required|string|max:255',
            'huyen' => 'required|string|max:100',
            'phuong' => 'required|string|max:100',
            'tinh' => 'required|string|max:100',
        ]);

        $address = new DiaChiGiaoHang();
        $address->maKH = $userId;
        $address->hoTen = $request->hoTen;
        $address->soDienThoai = $request->soDienThoai;
        $address->diaChi = $request->diaChi;
        $address->huyen = $request->huyen;
        $address->phuong = $request->phuong;
        $address->tinh = $request->tinh;

        $is_default = $request->input('diaChiMacDinh') == '1';
        $address->diaChiMacDinh = $is_default ? 1 : 0;

        if ($address->diaChiMacDinh == 1) {
            DiaChiGiaoHang::where('maKH', $userId)->update(['diaChiMacDinh' => 0]);
        }

        $address->save();

        return redirect()->route('addresses.danhsachdiachi')->with('success', 'Thêm địa chỉ thành công!');
    }


    public function edit($id)
    {
        $address = DiaChiGiaoHang::where('maKH', Auth::id())->where('maDiaChi', $id)->firstOrFail();
        return view('addresses.thongtindiachi', ['address' => $address, 'isNew' => false]);
    }

    public function update(Request $request, $id)
    {
        $address = DiaChiGiaoHang::where('maKH', Auth::id())->where('maDiaChi', $id)->firstOrFail();
        $data = $request->validate([
            'hoTen' => 'required|string|max:255',
            'soDienThoai' => 'required|string|max:15',
            'diaChi' => 'required|string|max:255',
            'huyen' => 'required|string|max:100',
            'phuong' => 'required|string|max:100',
            'tinh' => 'required|string|max:100',
            // Không cần validate diaChiMacDinh ở đây vì nó sẽ được xử lý riêng
        ]);

        // --- THAY ĐỔI TỪ ĐÂY ---
        // Kiểm tra giá trị của diaChiMacDinh được gửi lên
        $is_default = $request->input('diaChiMacDinh') == '1'; // Kiểm tra xem giá trị có phải là '1' không

        if ($is_default) {
            // Nếu người dùng chọn làm mặc định (checkbox được tick, giá trị là '1')
            $data['diaChiMacDinh'] = 1;
            // Reset các địa chỉ khác thành không mặc định
            DiaChiGiaoHang::where('maKH', Auth::id())
                ->where('maDiaChi', '!=', $id) // Loại trừ địa chỉ đang cập nhật
                ->update(['diaChiMacDinh' => 0]);
        } else {
            // Nếu người dùng không chọn làm mặc định (checkbox không tick, giá trị là '0')
            $data['diaChiMacDinh'] = 0;
            // Cân nhắc: Nếu đây là địa chỉ mặc định duy nhất và người dùng bỏ chọn,
            // bạn có thể muốn thêm logic để ngăn chặn hoặc chọn một địa chỉ khác làm mặc định.
            // Tuy nhiên, theo logic hiện tại, việc này sẽ làm địa chỉ này trở thành không mặc định.
        }
        // --- THAY ĐỔI ĐẾN ĐÂY ---
        $address->update($data); // Cập nhật địa chỉ với dữ liệu đã chuẩn bị (bao gồm cả diaChiMacDinh đúng)

        return redirect()->route('addresses.danhsachdiachi')->with('success', 'Cập nhật địa chỉ thành công!');
    }



    public function destroy($id)
    {
        $address = DiaChiGiaoHang::where('maKH', Auth::id())->where('maDiaChi', $id)->firstOrFail();
        $address->delete();
        return redirect()->route('addresses.danhsachdiachi')->with('success', 'Xóa địa chỉ thành công!');
    }
}

