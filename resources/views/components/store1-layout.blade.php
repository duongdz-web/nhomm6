@props(['title' => 'POCO'])

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; }
    </style>
</head>

<body class="bg-white text-gray-800">

    {{-- HEADER --}}
    <div class="bg-red-500 text-white px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <img src="{{ asset('banner/logo.png') }}" alt="Banner" class="w-auto h-[60px] object-contain">
        
        {{-- Thanh tìm kiếm --}}
        <div class="flex gap-3 items-center justify-center w-full md:w-auto md:flex-1">
            <input 
                type="text" 
                name="q" 
                form="searchForm"
                placeholder="Bạn tìm kiếm gì hôm nay?" 
                class="px-4 py-2 w-[400px] rounded-md border border-gray-300 focus:ring-2 focus:ring-yellow-400 focus:outline-none transition duration-200 text-gray-800"
            >
            <form id="searchForm" action="{{ route('products.search') }}" method="GET">
                <button type="submit" class="bg-yellow-400 px-5 py-2 rounded-md text-black font-semibold text-sm hover:bg-yellow-500 transition">
                    Tìm kiếm
                </button>
            </form>
        </div>

        {{-- Icon --}}
        <div class="flex gap-6 text-2xl relative">
            <a href="/" class="text-white hover:text-yellow-200 transition"><i class="fas fa-home"></i></a>
            <a href="{{ route('giohang.index') }}" class="text-white hover:text-yellow-200 transition"><i class="fas fa-shopping-cart"></i></a>

            <div class="relative">
                <button id="user-button" class="text-white hover:text-yellow-300 transition flex items-center gap-2">
                    <i class="fas fa-user"></i>
                    @auth <span class="text-sm font-medium">{{ Auth::user()->name }}</span> @endauth
                </button>
                <div id="user-dropdown" class="absolute right-0 mt-3 w-48 bg-white text-black rounded-xl shadow-lg hidden z-50">
                    @guest
                        <a href="{{ route('login') }}" class="block px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Đăng nhập</a>
                        <a href="{{ route('register') }}" class="block px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Đăng ký</a>
                    @endguest
                    @auth
                        <a href="{{ route('khachhang.sua') }}" class="block px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Tài khoản</a>
                        <a href="{{ route('dondathang.index') }}" class="block px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Đơn hàng của tôi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Đăng xuất</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>
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

    <main class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
            <!-- Cột trái: Bộ lọc -->
            <aside class="md:col-span-1 bg-white rounded-lg shadow p-4">
                <h2 class="text-lg font-semibold mb-3 text-center">BỘ LỌC TÌM KIẾM</h2>

                <!-- Lọc theo khoảng giá -->
                <div class="mb-4">
                    <h3 class="text-sm font-semibold mb-2">Khoảng giá (VNĐ)</h3>
                    <form action="{{ route('products.sort') }}" method="GET" class="space-y-2">
                        <div class="flex gap-2">
                            <input 
                                type="number" 
                                name="price_min" 
                                placeholder="Từ" 
                                value="{{ request('price_min') }}"
                                class="w-1/2 border border-gray-300 rounded-md p-2 text-sm"
                            >
                            <input 
                                type="number" 
                                name="price_max" 
                                placeholder="Đến" 
                                value="{{ request('price_max') }}"
                                class="w-1/2 border border-gray-300 rounded-md p-2 text-sm"
                            >
                        </div>
                        <button type="submit" class="w-full bg-yellow-500 text-black py-2 rounded-md hover:bg-yellow-600 text-sm font-medium">
                            Áp dụng khoảng giá
                        </button>
                    </form>
                </div>

                <!-- Lọc theo đánh giá -->
                <form action="{{ route('home') }}" method="GET">
                    <div>
                        <h3 class="text-sm font-semibold mb-2">Đánh giá tối thiểu</h3>
                        <div class="space-y-2">
                            @for ($i = 5; $i >= 1; $i--)
                                <div class="flex items-center gap-1">
                                    <label class="cursor-pointer flex items-center">
                                        <input 
                                            type="radio" 
                                            name="rating_min" 
                                            value="{{ $i }}" 
                                            {{ request('rating_min') == $i ? 'checked' : '' }}
                                            class="hidden"
                                            onchange="this.form.submit();"
                                        >
                                        @for ($j = 1; $j <= 5; $j++)
                                            <i class="fas fa-star {{ $j <= $i ? 'text-yellow-500' : 'text-gray-300' }} text-xl"></i>
                                        @endfor
                                    </label>
                                    <span>{{ $i }} Sao</span>
                                </div>
                            @endfor
                        </div>
                    </div>
                </form>

                <!-- Dịch vụ & Khuyến mãi -->
                <form action="{{ route('home') }}" method="GET">
                    <div>
                        <h3 class="text-sm font-semibold mb-2">Dịch vụ & Khuyến mãi</h3>
                        <div class="space-y-2">
                            <!-- Đang giảm giá -->
                            <div class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    name="promotion[]" 
                                    value="discount" 
                                    id="discount"
                                    {{ in_array('discount', request('promotion', [])) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-yellow-500"
                                    onchange="this.form.submit();"
                                >
                                <label for="discount" class="cursor-pointer text-sm">Đang giảm giá</label>
                            </div>

                            <!-- Hàng có sẵn -->
                            <div class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    name="promotion[]" 
                                    value="in_stock" 
                                    id="in_stock"
                                    {{ in_array('in_stock', request('promotion', [])) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-yellow-500"
                                    onchange="this.form.submit();"
                                >
                                <label for="in_stock" class="cursor-pointer text-sm">Hàng có sẵn</label>
                            </div>

                            <!-- Vận chuyển nhanh -->
                            <div class="flex items-center gap-2">
                                <input 
                                    type="checkbox" 
                                    name="promotion[]" 
                                    value="fast_shipping" 
                                    id="fast_shipping"
                                    {{ in_array('fast_shipping', request('promotion', [])) ? 'checked' : '' }}
                                    class="form-checkbox h-4 w-4 text-yellow-500"
                                    onchange="this.form.submit();"
                                >
                                <label for="fast_shipping" class="cursor-pointer text-sm">Vận chuyển nhanh</label>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Nút Reset bộ lọc -->
                <a href="{{ route('home') }}" class="block w-full mt-2 bg-gray-500 text-white py-2 rounded-md text-center hover:bg-gray-600 text-sm">
                    Xóa bộ lọc
                </a>


            </aside>

            <!-- Cột phải: Sản phẩm -->
            <div class="md:col-span-4">
                {{-- Grid sản phẩm đặt tại đây --}}
                {{ $slot }}
            </div>
        </div>
        
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userBtn = document.getElementById('user-button');
            const dropdown = document.getElementById('user-dropdown');

            if (userBtn && dropdown) {
                userBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    dropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', function () {
                    dropdown.classList.add('hidden');
                });
                dropdown.addEventListener('click', function (e) {
                    e.stopPropagation();
                });
            }
        });
    </script>
</body>
</html>
