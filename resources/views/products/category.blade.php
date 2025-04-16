<x-store1-layout>

    {{-- Sản phẩm nổi bật --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 p-4">
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
                                $soSao = round($product->danhgias->avg('soSao') ?? 0, 1);
                                $fullStars = floor($soSao);
                                $halfStar = ($soSao - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp

                            <!-- Hiển thị sao đầy -->
                            @for ($i = 0; $i < $fullStars; $i++)
                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                            @endfor

                            <!-- Hiển thị sao nửa -->
                            @if ($halfStar)
                                <i class="fas fa-star-half-alt text-yellow-400 text-xs"></i>
                            @endif

                            <!-- Hiển thị sao rỗng -->
                            @for ($i = 0; $i < $emptyStars; $i++)
                                <i class="far fa-star text-gray-300 text-xs"></i>
                            @endfor

                            <!-- Hiển thị số -->
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

</x-store1-layout>
