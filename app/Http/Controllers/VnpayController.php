<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
class VnpayController extends Controller
{
    // File xử lý tạo URL thanh toán (ví dụ: PaymentController)
    public function createPayment(Request $request)
    {
        $vnp_TmnCode = env('VNPAY_TMNCODE'); // Mã TMN Code sandbox bạn được cấp
        $vnp_HashSecret = env('VNPAY_HASHSECRET'); // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return'); // URL trả về sau khi thanh toán

        $vnp_TxnRef = rand(00,99999); // Mã giao dịch (random)
        $vnp_OrderInfo = 'Thanh toan don hang';
        $vnp_OrderType = 'billpayment';
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

        $vnp_Amount = session('total_payment') * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = 'NCB';
        $vnp_IpAddr = request()->ip();

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        // Nếu có chọn ngân hàng
        if (!empty($vnp_BankCode)) {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Bước 1: Sắp xếp mảng
        ksort($inputData);

        // Bước 2: Tạo chuỗi hashdata chuẩn theo VNPAY
        $hashdata = '';
        foreach ($inputData as $key => $value) {
            $hashdata .= urlencode($key) . '=' . urlencode($value) . '&';
        }
        $hashdata = rtrim($hashdata, '&');

        // Bước 3: Tạo chữ ký
        $vnp_SecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);

        // Bước 4: Tạo URL thanh toán
        $vnp_Url .= "?" . http_build_query($inputData) . '&vnp_SecureHash=' . $vnp_SecureHash;

        // Lưu thông tin đơn hàng vào session trước khi redirect
        session([
            'order_data' => [
                'hoTen' => $request->hoTen,
                'soDienThoai' => $request->soDienThoai,
                'ngayLap' => now()->toDateString(),
                'maKH' => $request->maKH,
                'tinhTrang' => 'Chờ xử lý',
                'deliveryMethod' => $request->donVi,
                'diaChi' => $request->diaChi,
                'selectedProducts' => session('selected_products')
            ]
        ]);

        return redirect($vnp_Url);
    }


    public function paymentReturn(Request $request)
    {
        $vnp_ResponseCode = $request->input('vnp_ResponseCode');
        if ($vnp_ResponseCode == '00') {
            // Lấy lại dữ liệu đơn hàng từ session
            $order = session('order_data');
            $totalPayment = session('total_payment');
            $discountId = session('selected_discount_id');

            if ($order) {
                DB::beginTransaction();
                try {
                    // 1. Insert vào dondathang
                    $maDH = DB::table('dondathang')->insertGetId([
                        'tenKH' => $order['hoTen'],
                        'soDienThoai' => $order['soDienThoai'],
                        'ngayLap' => $order['ngayLap'],
                        'maKH' => $order['maKH'],
                        'tinhTrang' => $order['tinhTrang'],
                        'donVi' => $order['deliveryMethod'],
                        'diaChi' => $order['diaChi'],
                        'tinhTrangThanhToan' => 'Đã thanh toán',
                        'tongTienThanhToan' => $totalPayment, // Lưu tổng tiền thanh toán
                        'idMaGG' => $discountId // Lưu ID mã giảm giá
                    ]);

                    // 2. Insert vào chitietdondat
                    $products = $order['selectedProducts'];

                    Log::info('Insert chi tiết đơn hàng', ['products' => $products]);

                    foreach ($products as $product) {
                        DB::table('chitietdondat')->insert([
                            'maDH' => $maDH,
                            'maSP' => $product['maSP'],
                            'soLuong' => $product['quantity'],
                            'giaBan' => $product['price']
                        ]);
                        Log::info('Đang insert sản phẩm', ['maSP' => $product['maSP']]);

                        // 3. Xoá khỏi giỏ hàng
                        DB::table('giohang')
                            ->where('maKH', $order['maKH'])
                            ->where('maSP', $product['maSP'])
                            ->delete();
                    }

                    // 4. Xoá mã giảm giá đã dùng khỏi bảng discount_kh
                    DB::table('discounts_kh')
                    ->where('maKH', $order['maKH'])
                    ->where('idMaGG', $discountId)
                    ->delete();

                    DB::commit();

                    // Xoá session sau khi lưu xong
                    session()->forget('order_data');
                    session()->forget('selected_products');
                    session()->forget('total_payment');
                    session()->forget('selected_discount_id');

                    return redirect()->route('dondathang.index')->with('success', 'Thanh toán và đặt hàng thành công!');
                } catch (\Exception $e) {
                    DB::rollBack();
                    return "Có lỗi khi lưu đơn hàng: " . $e->getMessage();
                }
            }
            return "Không tìm thấy dữ liệu đơn hàng trong session!";
        } else {
            return redirect()->route('dathang.show')->with('false', 'Giao dịch thất bại hoặc bị huỷ!');
        }
    }
}

