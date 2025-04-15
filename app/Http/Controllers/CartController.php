<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TestSendEmail;
use App\Models\User;
class CartController extends Controller
{
    function giohang()
    {
        if (session()->has('selected_products')) {
            session()->forget('selected_products');
        }

      $maKH = Auth::user()->id;
        $cartItems = DB::select("
            SELECT 
                s.maSP, 
                s.tenSP, 
                s.hinhanh, 
                s.giaBan, 
                s.giaBanGoc, 
                g.soLuong, 
                (COALESCE(s.giaBan, s.giaBanGoc) * g.soLuong) AS thanhTien
            FROM giohang g
            JOIN sanpham s ON g.maSP = s.maSP
             WHERE g.maKH = ?", [$maKH]);
        return view("store.giohang", compact("cartItems"));
    }

    function capnhapsoluong(Request $request)
    {
        $maKH = Auth::user()->id;
        $maSP = $request->maSP;
        $action = $request->action;

        $item = DB::table('giohang')
            ->where('maKH', $maKH)
            ->where('maSP', $maSP)
            ->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.']);
        }

        $soLuongMoi = $item->soLuong;
        if ($action === 'increase') {
            $soLuongMoi++;
        } elseif ($action === 'decrease') {
            if ($soLuongMoi <= 1) {
                return response()->json(['success' => false, 'message' => 'Không thể giảm dưới 1.']);
            }
            $soLuongMoi--;
        }

        DB::update("UPDATE giohang SET soLuong = ? WHERE maKH = ? AND maSP = ?", [
            $soLuongMoi,
            $maKH,
            $maSP
        ]);

        // Lấy đơn giá từ bảng sản phẩm (giả sử có bảng 'sanpham' và cột 'giaBan')
        $sanpham = DB::table('sanpham')->where('maSP', $maSP)->first();
        $giaBan = $sanpham->giaBan ?? $sanpham->giaBanGoc;

        $thanhTienMoi = $giaBan * $soLuongMoi;

        $giohang = DB::table('giohang')
            ->where('maKH', $maKH)
            ->get();

        $tongTien = 0;
        foreach ($giohang as $gh) {
            $sanpham = DB::table('sanpham')->where('maSP', $gh->maSP)->first();
            $gia = $sanpham->giaBan ?? $sanpham->giaBanGoc;

            $tongTien += $gh->soLuong * $gia;
        }
        return response()->json([
            'success' => true,
            'newQuantity' => $soLuongMoi,
            'newTotal' => $thanhTienMoi,
            'totalCartAmount' => $tongTien,
        ]);
    }

    public function xoaSanPham(Request $request)
    {
        $maSP = $request->maSP;
        $maKH = Auth::user()->id;

        $item = DB::table('giohang')
            ->where('maKH', $maKH)
            ->where('maSP', $maSP)
            ->first();

        if (!$item) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'
            ]);
        }

        DB::table('giohang')
            ->where('maKH', $maKH)
            ->where('maSP', $maSP)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Xóa sản phẩm khỏi giỏ hàng thành công.'
        ]);
    }
    public function store(Request $request)
    {
        $maKH = Auth::user()->id;
        $maSP = trim($request->input('product_id'));
        $soLuong = intval($request->input('quantity', 1));

        if (!$maSP) {
            return redirect()->back()->withErrors(['Lỗi: Không có mã sản phẩm được gửi.']);
        }


        // Log kiểm tra
        Log::info('THÊM GIỎ HÀNG', ['maKH' => $maKH, 'maSP' => $maSP, 'soLuong' => $soLuong]);

        $item = DB::table('giohang')
            ->where('maKH', $maKH)
            ->where('maSP', $maSP) // Laravel sẽ tự thêm dấu nháy đơn
            ->first();

        if ($item) {
            DB::table('giohang')
                ->where('maKH', $maKH)
                ->where('maSP', $maSP)
                ->update([
                    'soLuong' => $item->soLuong + $soLuong,
                ]);
        } else {
            DB::table('giohang')->insert([
                'maKH' => $maKH,
                'maSP' => $maSP,
                'soLuong' => $soLuong,
            ]);
        }
        //Lưu trạng thái checkbox

        $cartSession = session('cart', []);
        $cartSession[$maSP] = ['checked' => 0]; // luôn gán checked mặc định
        session(['cart' => $cartSession]);

        return redirect()->route('giohang.index')->with('success', 'Đã thêm vào giỏ hàng!');
    }

    public function checkbox(Request $request)
    {
        $maSP = $request->input('maSP');
        $checked = $request->input('checked');
        $cart = session('cart', []);

        if (isset($cart[$maSP])) {
            $cart[$maSP]['checked'] = $checked;
            Log::info('Cart sau khi update checkbox:', $cart); // log ra file laravel.log
            session(['cart' => $cart]);
            return response()->json([
                'success' => true,
                'message' => 'Trạng thái chọn đã được cập nhật.'
            ]);
        }


        return response()->json([
            'success' => false,
            'message' => 'Không tìm thấy sản phẩm trong giỏ.'
        ]);
    }

    function testemail()
    {
        $user = User::find(1);
        $donHang = DB::select("select * from chitietdondat c, sanpham s
                        where c.maSP = s.maSP
                        and c.maDH = 11");
        $user->notify(new TestSendEmail($donHang));
    }
}
