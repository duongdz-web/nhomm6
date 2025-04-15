<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Discount;
class CODController extends Controller
{
    public function processCOD(Request $request)
    {
        try {
            DB::beginTransaction();
            $shippingFee = $request->input('shipping_fee', 0);
            $discountId = $request->input('selectedDiscount');

            // Tính số tiền giảm giá
            $discountAmount = 0;
            if ($discountId) {
                $discount = Discount::find($discountId);
                if ($discount) {
                    $discountAmount = $discount->soTienGiam;
                }
            }

            $subtotal = session('subtotal', 0);

            // Cập nhật session
            session([
                'shipping_fee' => $shippingFee,
                'discount_amount' => $discountAmount,
                'total_payment' => $subtotal + $shippingFee - $discountAmount,
                'selected_discount_id' => $discountId // Lưu ID mã giảm giá vào session
            ]);
            $totalPayment = session('total_payment');
            $maDH = DB::table('dondathang')->insertGetId([
                'tenKH' => $request->hoTen,
                'soDienThoai' => $request->soDienThoai,
                'ngayLap' => $request->ngayLap,
                'maKH' => $request->maKH,
                'tinhTrang' => $request->tinhTrang,
                'donVi' => $request->delivery_method,
                'diaChi' => $request->diaChi,
                'tinhTrangThanhToan' => 'Chưa thanh toán',
                'tongTienThanhToan' => $totalPayment, // Lưu tổng tiền thanh toán
                'idMaGG' => $request->selectedDiscount // Lưu ID mã giảm giá
            ]);

            $products = session('selected_products');

            foreach ($products as $product) {
                DB::table('chitietdondat')->insert([
                    'maDH' => $maDH,
                    'maSP' => $product['maSP'],
                    'soLuong' => $product['quantity'],
                    'giaBan' => $product['price']
                ]);

                DB::table('giohang')
                    ->where('maKH', $request->maKH)
                    ->where('maSP', $product['maSP'])
                    ->delete();
            }
            
            DB::table('discounts_kh')
            ->where('maKH', $request->maKH)
            ->where('idMaGG', $discountId)
            ->delete();

            DB::commit();
            session()->forget('selected_products');
            session()->forget('total_payment');
            session()->forget('selected_discount_id');

            return redirect()->route('home')->with('success', 'Đặt hàng thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('false', 'Lỗi khi đặt hàng: ' . $e->getMessage());
        }
    }
}


