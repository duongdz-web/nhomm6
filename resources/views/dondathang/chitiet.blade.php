<x-store-layout>
<div class="container py-5">
    <h2 class="text-xl font-semibold mb-4">Chi tiết đơn hàng #{{ $dondathang->maDH }}</h2>

    <div class="bg-white rounded-xl shadow-md p-4 mb-4">
        <p><strong>Ngày đặt:</strong> {{ $dondathang->ngayLap->format('d/m/Y') }}</p>
        <p><strong>Trạng thái:</strong> {{ $dondathang->tinhTrang }}</p>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded-xl shadow text-sm">
            <thead>
                <tr class="bg-gray-100 text-left">
                    <th class="p-3">Ảnh</th>
                    <th class="p-3">Tên sản phẩm</th>
                    <th class="p-3">Mã SP</th>
                    <th class="p-3">Số lượng</th>
                    <th class="p-3">Giá bán</th>
                    <th class="p-3">Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dondathang->chitietdondat as $ct)
                <tr class="border-t">
                    <td class="p-3 w-20">
                        @if($ct->sanpham && $ct->sanpham->hinhanh)
                            <img src="{{ asset('storage/' . $ct->sanpham->hinhanh) }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-100 text-gray-400 text-xs flex items-center justify-center">Không có ảnh</div>
                        @endif
                    </td>
                    <td class="p-3">{{ $ct->sanpham->tenSP ?? 'Sản phẩm đã xóa' }}</td>
                    <td class="p-3">{{ $ct->maSP }}</td>
                    <td class="p-3">{{ $ct->soLuong }}</td>
                    <td class="p-3">{{ number_format($ct->giaBan) }}₫</td>
                    <td class="p-3">{{ number_format($ct->giaBan * $ct->soLuong) }}₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</x-store-layout>
