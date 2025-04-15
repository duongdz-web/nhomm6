<x-store1-layout>

    {{-- Sản phẩm nổi bật --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 p-4">
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Thành công',
                    text: '{{ session("success") }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif

    @foreach ($products as $product)
        <a href="{{ route('products.chitiet', ['maSP' => $product->maSP]) }}">
            <div class="bg-white border rounded-md shadow hover:shadow-lg transition duration-300">
                <div class="w-full h-60 bg-white overflow-hidden flex items-center justify-center">
                    <img src="{{ asset('sanpham/' . $product->hinhanh) }}" alt="{{ $product->tenSP }}" class="w-full h-full object-cover">
                </div>
                <div class="p-3 text-center">
                    <h3 class="text-base font-semibold text-red-700 truncate">{{ $product->tenSP }}</h3>
                    @php
                        $giaHienThi = $product->giaBan ?? $product->giaBanGoc;
                    @endphp
                    <p class="text-green-600 font-bold mt-1">{{ number_format($giaHienThi, 0, ',', '.') }} VND</p>

                    <!-- Đánh giá + lượt bán cùng 1 hàng -->
                    <div class="mt-2 text-sm text-gray-600 flex justify-center items-center space-x-2">
                        <!-- Đánh giá -->
                        <div class="flex items-center">
                            @php
                                // Lấy soSao từ bảng danhgia (ví dụ lấy sao của đánh giá đầu tiên)
                                $soSao = $product->danhgias->isEmpty() ? 0 : $product->danhgias->first()->soSao;
                                
                                $fullStars = floor($soSao); // Số sao đầy
                                $halfStar = ($soSao - $fullStars) >= 0.5; // Kiểm tra nếu có sao nửa
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Số sao rỗng
                            @endphp

                            <!-- Hiển thị sao đầy -->
                            @for ($i = 0; $i < $fullStars; $i++)
                                <span class="text-yellow-400">★</span>
                            @endfor

                            <!-- Hiển thị sao nửa -->
                            @if ($halfStar)
                                <span class="text-yellow-400">☆</span>
                            @endif

                            <!-- Hiển thị sao rỗng -->
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <span class="text-gray-300">★</span>
                            @endfor

                            <!-- Hiển thị số sao -->
                            <span class="ml-1 text-xs text-gray-500">({{ number_format($soSao, 1) }})</span>
                        </div>
                        <!-- Lượt bán -->
                        <div class="text-xs text-gray-500">Lượt bán: {{ $product->soLuongDaBan }}</div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    </div>
    <!-- Pagination (Chuyển trang) -->
    <div class="flex justify-center mt-6">
        {{ $products->links() }}
    </div>
</x-store1-layout>
