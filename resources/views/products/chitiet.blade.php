<x-store-layout>
    <div class="max-w-6xl mx-auto p-6">
        <div class="border rounded-xl p-6 shadow-md bg-white">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Cột trái: Ảnh sản phẩm --}}
                <div class="flex justify-center">
                    <img src="{{ asset('sanpham/' . $product->hinhanh) }}" alt="{{ $product->tenSP }}"
                        class="max-h-80 object-contain">
                </div>

                {{-- Cột phải: Thông tin sản phẩm ngay trên cùng --}}
                <div class="space-y-4">

                    <h1 class="text-3xl font-bold text-gray-800">{{ $product->tenSP }}</h1>
                    <div class="flex items-center mt-1">
                        @if (!is_null($product->giaBan) && $product->giaBan < $product->giaBanGoc)
                            <p class="text-xl text-red-600 font-semibold">
                                {{ number_format($product->giaBan, 0, ',', '.') }} đ
                            </p>
                            <p class="text-base text-gray-500 italic line-through ml-3">
                                {{ number_format($product->giaBanGoc, 0, ',', '.') }} đ
                            </p>
                        @else
                            <p class="text-xl text-red-600 font-semibold">
                                {{ number_format($product->giaBanGoc, 0, ',', '.') }} đ
                            </p>
                        @endif
                    </div>

                    {{-- Số lượng --}}
                    <div class="flex items-center space-x-3">
                        <label for="quantity" class="text-base font-medium">Số lượng:</label>
                        <div class="flex items-center border rounded-md">
                            <button type="button" class="px-3 py-1 text-lg" onclick="decreaseQuantity()">-</button>
                            <input id="quantity" name="quantity_display" type="text" value="1"
                                class="w-12 text-center border-l border-r outline-none" readonly>
                            <button type="button" class="px-3 py-1 text-lg" onclick="increaseQuantity()">+</button>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-4">
                        <form method="POST" action="{{ route('giohang.store') }}">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ Str::of($product->maSP)->trim() }}">
                            <input type="hidden" id="form-quantity" name="quantity" value="1">

                            <button type="submit"
                                class="bg-white border border-black px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition flex items-center">
                                <i class="fas fa-shopping-cart mr-2"></i> Thêm vào giỏ hàng
                            </button>
                        </form>

                        <form id="muahang-form" action="{{ route('dathang.show') }}" method="POST">
                            @csrf
                            <input type="hidden" id="product-data" name="products" value="">
                            <button type="submit"
                                class="bg-gradient-to-r from-green-300 to-blue-300 px-4 py-2 rounded-md font-medium hover:brightness-110 transition">
                                Mua hàng
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mô tả chi tiết bên dưới --}}
            <div class="mt-8">
                <h2 class="font-semibold text-lg mb-2">Thông tin sản phẩm:</h2>
                <p class="text-justify leading-relaxed">
                    {{ $product->moTa }}
                </p>
            </div>
        </div>
    </div>

    <script>
        function increaseQuantity() {
            let input = document.getElementById('quantity');
            let val = parseInt(input.value);
            input.value = val + 1;
            document.getElementById('form-quantity').value = input.value;
        }

        function decreaseQuantity() {
            let input = document.getElementById('quantity');
            let val = parseInt(input.value);
            if (val > 1) input.value = val - 1;
            document.getElementById('form-quantity').value = input.value;
        }
    </script>
    <script>
        document.getElementById('muahang-form').addEventListener('submit', function (e) {
            const quantity = document.getElementById('quantity').value;
            const data = [{
                maSP: '{{ $product->maSP }}',
                soLuong: quantity
            }];
            document.getElementById('product-data').value = JSON.stringify(data);
        });
    </script>

</x-store-layout>