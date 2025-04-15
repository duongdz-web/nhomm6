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
        .title_order{
            font-size: 40px;
            font-weight: bold;
        }
    </style>
</head>

<body class="bg-white text-gray-800">

    {{-- HEADER --}}
    <div class="bg-red-500 text-white px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
        @if (request()->routeIs('dathang.show'))
            <div class="flex items-center">
                <img src="{{ asset('banner/logo.png') }}" alt="Banner" class="w-auto h-[60px] object-contain">
                <img src="{{ asset('banner/duongthang.png') }}" class="w-auto h-[60px] object-contain">
                <span class="title_order"> ĐẶT HÀNG</span>
            </div>
        @else
            <img src="{{ asset('banner/logo.png') }}" alt="Banner" class="w-auto h-[60px] object-contain">
        @endif
        
        {{-- Thanh tìm kiếm --}}
        @unless (request()->routeIs('dathang.show'))
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
        @endunless

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
                        <a href="{{ route('account') }}" class="block px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Tài khoản</a>
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

    <main class="">
        {{ $slot }}
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
