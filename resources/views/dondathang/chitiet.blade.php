<x-store-layout>
    <div class="container py-5">
        <h2 class="text-base font-semibold text-gray-800">🧾 Mã đơn: {{ $dondathang->maDH }}</h2>

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
                        @if($dondathang->tinhTrang === 'Đã giao')
                            <th class="p-3">Đánh giá</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($dondathang->chitietdondat as $ct)
                        <tr class="border-t">
                            {{-- Cột ảnh --}}
                            <td class="p-3 w-20">
                                @if($ct->sanpham && $ct->sanpham->hinhanh)
                                
                                    <img src="{{ asset('sanpham/' . $ct->sanpham->hinhanh) }}" class="w-16 h-16 object-cover rounded">
                                @else
                                    <div class="w-16 h-16 bg-gray-100 text-gray-400 text-xs flex items-center justify-center">Không có ảnh</div>
                                @endif
                            </td>

                            {{-- Tên sản phẩm --}}
                            <td class="p-3">
                                @if($ct->sanpham)
                                    <a href="{{ route('products.chitiet', $ct->sanpham->maSP) }}" class="text-blue-600 hover:underline">
                                        {{ $ct->sanpham->tenSP }}
                                    </a>
                                @else
                                    Sản phẩm đã xóa
                                @endif
                            </td>

                            {{-- Mã SP --}}
                            <td class="p-3">{{ $ct->maSP }}</td>

                            {{-- Số lượng --}}
                            <td class="p-3">{{ $ct->soLuong }}</td>

                            {{-- Giá bán --}}
                            <td class="p-3">{{ number_format($ct->giaBan) }}₫</td>

                            {{-- Thành tiền --}}
                            <td class="p-3">{{ number_format($ct->giaBan * $ct->soLuong) }}₫</td>

                            {{-- Đánh giá (chỉ nếu đã giao) --}}
                            @if($dondathang->tinhTrang === 'Đã giao')
                            @php
    $daDanhGia = \App\Models\DanhGiaSanPham::where('maDH', $dondathang->maDH)
        ->where('maSP', $ct->maSP)
        ->whereNotNull('soSao')
        ->whereNotNull('moTa')
        ->first();
@endphp
                                <td class="p-3">
                                    @if($daDanhGia)
                                        <a href="{{ route('dondathang.danhgia', ['maDH' => $dondathang->maDH, 'maSP' => $ct->maSP]) }}"
                                           class="text-green-600 hover:underline">
                                            Đã đánh giá
                                        </a>
                                    @else
                                        <a href="{{ route('dondathang.danhgia', ['maDH' => $dondathang->maDH, 'maSP' => $ct->maSP]) }}"
                                           class="text-blue-600 hover:underline">
                                            Chưa đánh giá
                                        </a>
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-store-layout>
