<x-store-layout>
<head>
        <style>
            /* Thêm CSS của bạn ở đây */
            .rating {
                display: inline-block;
            }

            .star {
                font-size: 24px;
                color: gray;
                cursor: pointer;
            }

            .star.active {
                color: gold;
            }
        </style>
    </head>
    <div class="container py-5 max-w-xl mx-auto">
    <h2 class="text-xl font-semibold mb-4" style="text-align: center;">Đánh giá sản phẩm</h2>

        <div class="bg-white p-4 rounded shadow-md">
            {{-- Thông tin sản phẩm --}}
            <div class="flex gap-4 mb-4">
                <div class="w-24 h-24 bg-gray-100 rounded overflow-hidden">
                    @if($chiTiet->sanpham && $chiTiet->sanpham->hinhanh)
                    
                        <img src="{{ asset('sanpham/' . $chiTiet->sanpham->hinhanh) }}" class="object-cover w-full h-full">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-400 text-xs">Không có ảnh</div>
                    @endif
                </div>
                <div>
                <p class="font-semibold text-gray-900 text-xl">
    {{ $chiTiet->sanpham->tenSP ?? 'Sản phẩm đã xóa' }}
</p>
<p class="font-semibold text-gray-800">
    Mã SP: <span class="text-red-600">{{ $chiTiet->maSP }}</span>
</p>
<p class="font-semibold text-gray-800">
    Giá bán: <span class="text-red-600">{{ number_format($chiTiet->giaBan) }}₫</span>
</p>
                </div>
            </div>

            @if($canDanhGia) {{-- Kiểm tra nếu chưa đánh giá --}}
                {{-- Form đánh giá --}}
                <form method="POST" action="{{ route('dondathang.danhgia.luu', [$chiTiet->maDH, $chiTiet->maSP]) }}">
                    @csrf
                    <div class="mb-4">
    <label class="block text-gray-700 font-medium mb-1">Số sao:</label>
    <div class="rating">
        @for($i = 1; $i <= 5; $i++)
            <span class="star" data-value="{{ $i }}">★</span>
        @endfor
        <input type="hidden" name="soSao" id="rating-value" value="">
    </div>
</div>
<script>
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('rating-value');

    stars.forEach(star => {
        star.addEventListener('mouseover', function() {
            const value = this.getAttribute('data-value');
            highlightStars(value);
        });

        star.addEventListener('click', function() {
            const value = this.getAttribute('data-value');
            ratingValue.value = value;
        });
    });

    function highlightStars(value) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= value) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
    }
</script>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Mô tả:</label>
                        <textarea name="moTa" rows="4" class="w-full border-gray-300 rounded" placeholder="Viết cảm nhận của bạn..." required></textarea>
                    </div>

                    <div class="flex justify-center">
    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        Gửi đánh giá
    </button>
</div>
                </form>
            @else {{-- Nếu đã có đánh giá --}}
                {{-- Hiển thị đánh giá nếu đã đánh giá --}}
                <div class="mb-2">
                    <p><strong>Số sao:</strong> {{ $danhGia->soSao }} ⭐</p>
                    <p><strong>Mô tả:</strong></p>
                    <p class="text-gray-700">{{ $danhGia->moTa }}</p>
                </div>
            @endif
        </div>
    </div>
</x-store-layout>
