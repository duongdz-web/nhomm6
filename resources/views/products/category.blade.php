<x-store-layout>

{{-- Banner Full Width --}}
    <div class="w-full">
        <img src="{{ asset('banner/1.png') }}" alt="Banner" class="w-full h-[450px] object-cover shadow-md">
    </div>

    {{-- Danh mục Full Width --}}
    <div class="grid grid-cols-4 md:grid-cols-8 gap-6 bg-red-600 py-4 text-white font-semibold shadow-md w-full">
        @php
            $categories = [
                ['icon' => 'fa-utensils', 'label' => 'Đồ ăn', 'code' => 'LS0001'],
                ['icon' => 'fa-coffee', 'label' => 'Đồ uống', 'code' => 'LS0002'],
                ['icon' => 'fa-couch', 'label' => 'Tiện ích gia đình', 'code' => 'LS0003'],
                ['icon' => 'fa-box', 'label' => 'Hàng gia dụng', 'code' => 'LS0004'],
                ['icon' => 'fa-pencil-alt', 'label' => 'Văn phòng phẩm', 'code' => 'LS0005'],
                ['icon' => 'fa-gamepad', 'label' => 'Đồ chơi', 'code' => 'LS0006'],
                ['icon' => 'fa-magic', 'label' => 'Sản phẩm làm đẹp', 'code' => 'LS0007'],
                ['icon' => 'fa-boxes', 'label' => 'Thực phẩm đóng hộp', 'code' => 'LS0008'],
            ];
        @endphp

        @foreach ($categories as $cat)
            <a href="{{ route('category.show', ['maLoai' => $cat['code']]) }}" class="flex flex-col items-center justify-center hover:text-yellow-200 transition duration-200">
                <i class="fas {{ $cat['icon'] }} text-3xl mb-2"></i>
                <span class="text-base text-center">{{ $cat['label'] }}</span>
            </a>
        @endforeach
    </div>

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
                    <p class="text-green-600 font-bold mt-1">{{ number_format($product->giaBan, 0, ',', '.') }} VND</p>


                    <!-- Đánh giá + lượt bán cùng 1 hàng -->
                    <div class="mt-2 text-sm text-gray-600 flex justify-center items-center space-x-2">
                        <!-- Đánh giá -->
                        <div class="flex items-center">
                            @php
                                $fullStars = floor($product->rating);
                                $halfStar = ($product->rating - $fullStars) >= 0.5;
                                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                            @endphp

                            @for ($i = 0; $i < $fullStars; $i++)
                                <span class="text-yellow-400">★</span>
                            @endfor

                            @if ($halfStar)
                                <span class="text-yellow-400">☆</span> {{-- hoặc dùng icon nửa sao nếu có --}}
                            @endif

                            @for ($i = 0; $i < $emptyStars; $i++)
                                <span class="text-gray-300">★</span>
                            @endfor

                            <span class="ml-1 text-xs text-gray-500">({{ number_format($product->rating, 1) }})</span>
                        </div>

                        <!-- Lượt bán -->
                        <div class="text-xs text-gray-500">Lượt bán: {{ $product->soLuongDaBan }}</div>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
</div>


</x-store-layout>
