<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GioHang;
use App\Models\Product;
use App\Models\Discount;
use App\Models\DiaChiGiaoHang;
use Illuminate\Support\Facades\Log;

class DatHangController extends Controller
{
    public function show(Request $request)
    {
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục.');
        }
        if (session()->has('shipping_fee')) {
            session()->forget('shipping_fee');
        }
        if (session()->has('discount_amount')) {
            session()->forget('discount_amount');
        }
        if (session()->has('total_payment')) {
            session()->forget('total_payment');
        }

        $selectedProducts = [];
        $subtotal = 0;
        $totalQuantity = 0;
        // Ưu tiên dùng dữ liệu từ session nếu có (ví dụ khi quay lại sau khi huỷ thanh toán)
        if (session()->has('selected_products')) {
            $selectedProducts = session('selected_products');
            $subtotal = session('subtotal', 0);
            $totalQuantity = session('totalQuantity', 0);
        } elseif ($request->has('products')) {
            $productsJson = $request->input('products');
            $productsArray = json_decode($productsJson, true);

            if (is_array($productsArray)) {
                foreach ($productsArray as $product) {
                    $maSP = $product['maSP'] ?? null;
                    $soLuong = $product['soLuong'] ?? 1;

                    $sanPham = Product::find($maSP);

                    if ($sanPham) {
                        $gia = $sanPham->giaBan ?? $sanPham->giaBanGoc; // fallback giá             
                        $thanhTien = $gia * $soLuong;       
                        $selectedProducts[] = [
                            'maSP' => $maSP,
                            'image' => $sanPham->hinhanh ?? '',
                            'name' => $sanPham->tenSP ?? 'Sản phẩm không tên',
                            'price' => $gia,
                            'quantity' => $soLuong,
                            'totalPrice' => $thanhTien,
                        ];
                    

                        $subtotal += $thanhTien;
                        $totalQuantity += $soLuong;
                    }
                }
            }
        } else {
            // Nếu không có danh sách gửi lên, dùng giỏ hàng trong DB
            $cartItems = GioHang::with('sanPham')->where('maKH', $userId)->get();

            foreach ($cartItems as $item) {
                if (!$item->sanPham)
                    continue;

                $quantity = $item->soLuong;

                // Ưu tiên giá bán, nếu không có thì lấy giá gốc
                $price = $item->sanPham->giaBan ?? $item->sanPham->giaBanGoc ?? 0;
                $totalPrice = $price * $quantity;

                $selectedProducts[] = [
                    'maSP' => $item->maSP,
                    'image' => $item->sanPham->hinhanh ?? '',
                    'name' => $item->sanPham->tenSP ?? 'Sản phẩm không tên',
                    'price' => $price,
                    'quantity' => $quantity,
                    'totalPrice' => $totalPrice,
                ];

                $subtotal += $totalPrice;
                $totalQuantity += $quantity;
            }
        }


        // Nếu có sản phẩm được chọn thì cập nhật session đúng
        if (!empty($selectedProducts)) {
            session([
                'selected_products' => $selectedProducts,
                'subtotal' => $subtotal,
                'totalQuantity' => $totalQuantity,
                'shipping_fee' => session('shipping_fee', 0),
                'discount_amount' => session('discount_amount', 0),
                'total_payment' => $subtotal + session('shipping_fee', 0) - session('discount_amount', 0),
            ]);
        }

        // Lấy địa chỉ giao hàng
        $addressId = $request->input('address_id');

        $address = $addressId
            ? DiaChiGiaoHang::where('maKH', $userId)->where('maDiaChi', $addressId)->first()
            : DiaChiGiaoHang::where('maKH', $userId)->where('diaChiMacDinh', 1)->first()
            ?? DiaChiGiaoHang::where('maKH', $userId)->first();

        $hoTen = $address->hoTen ?? '';
        $soDienThoai = $address->soDienThoai ?? '';
        $diaChi = $address
            ? implode(', ', array_filter([$address->diaChi, $address->phuong, $address->huyen, $address->tinh]))
            : '';
            // Truy vấn mã giảm giá theo cả điều kiện đơn hàng tối thiểu và thuộc về khách hàng
        $availableDiscounts = Discount::where('dieuKienDonHangToiThieu', '<=', $subtotal)
        ->whereIn('idMaGG', function($query) use ($userId) {
            $query->select('idMaGG')
                ->from('discounts_kh')
                ->where('maKH', $userId);
        })
        ->get();          
        return view('store.dathang', [
            'discounts' => $availableDiscounts,
            'subtotal' => $subtotal,
            'shippingFee' => session('shipping_fee', 0),
            'discountAmount' => session('discount_amount', 0),
            'totalPayment' => $subtotal,
            'selected_products' => $selectedProducts,
            'address' => $address,
            'hoTen' => $hoTen,
            'soDienThoai' => $soDienThoai,
            'tinh' => $address->tinh ?? null,
            'diaChi' => $diaChi,
        ]);
    }
}
