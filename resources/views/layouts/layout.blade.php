<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'POCO') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .title{
            font-size: 40px;
            font-weight: bold;
        }
        .header-tabs a {
            padding: 12px 20px;
            display: inline-block;
            text-decoration: none;
            color: black;
        }
        .header-tabs a.active {
            border-bottom: 3px solid #000;
            font-weight: bold;
        }
        .customer-table th, .customer-table td {
            vertical-align: middle;
            text-align: center;
        }
        .filter-box input, .filter-box select {
            margin-bottom: 8px;
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 50px;
            background: linear-gradient(to right, #cafbda, #95bbfe);
            border-bottom: 2px solid #ddd;
        }
        .header ul li a{
            text-decoration: none;
            font-size: 25px;
            color: #000000;  
        }
        .header ul {
            list-style: none;
            display: flex;
            align-items: center;
            padding: 0;
            margin: 0;
        }
        .header ul li {
            margin: 0 15px;
        }
        .header img {
            width: 120px;
        }
        .header input[type="text"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 300px;
        }
        .header button {
            padding: 10px 20px;
            background-color: #FFC0CB;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }
        .header button:hover{
            transform: scale(1.05);  
        }
        .header div ul li i {
            font-size: 30px;
            color: #333;
            margin-bottom: 10px;
        }
        .menu {
            display: flex;
            justify-content: space-around;
            padding: 20px;
            background: linear-gradient(to right, #cafbda, #95bbfe);
        }
        .menu div {
            text-decoration: none;
            text-align: center;
            cursor: pointer;
        }
        .menu div i {
            font-size: 30px;
            color: #333;
            margin-bottom: 10px;
        }
        .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
        }
        .product-card {
            width: 150px;
            margin: 10px;
            text-align: center;
        }
        .product-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, auto);
            grid-gap: 15px;
            justify-items: center;
        }
        .item {
            border: 1px solid #ededed;
            width: 200px;
            text-align: center;
            font-size: 15px;
            overflow: hidden;
        }
        .item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        a {
            text-decoration: none;
        }
        .item:hover {
            transform: scale(1.05);
        }
        .product-name {
            font-weight: bold;
            margin: 10px 0;
        }


        .product-price {
            color: #ff7f7f;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .grid-container {
            display: grid;
            grid-template-columns: repeat(5, 1fr); 
            grid-gap: 15px;
            justify-items: center;
        }
        .item {
            border: 1px solid #ededed;
            width: 200px;
            text-align: center;
            font-size: 15px;
            overflow: hidden;
        }
        .item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        a {
            text-decoration: none;
        }
        .item:hover {
            transform: scale(1.05);
        }
        .menu div:hover{
            transform: scale(1.05);
        }
        ul li a i:hover{
            transform: scale(1.05);
        }
        .bar{
            display: flex;
            justify-content: space-around;
            padding: 10px;
            background-color: #ededed;
        }
        .bar ul {
            list-style: none;
            display: flex;
            align-items: center;
            padding: 0;
            margin: 0;
            justify-content: space-between; 
            width: 100%; 
        }
        .bar ul li {
            flex: 1; 
            text-align: center; 
        }
        .header-tabs {
            background-color: #ff4d4d; /* đỏ tươi */
            padding: 10px 0;
            border-radius: 5px;
        }

        .header-tabs a {
            color: white !important;
        }

        .header-tabs a.active {
            border-bottom: 3px solid white;
        }

        .bar ul li a.active {
            text-decoration: underline;
            font-weight: bold;
        }
        .product-table {
            display: flex;
            justify-content: center; 
            align-items: center; 
            width: 100%;
            margin: 20px auto;
        }

        .sanpham {
            width: 90%; 
            max-width: 1200px; 
            border-collapse: collapse; 
        }

        .sanpham th, .sanpham td {
            border: 1px solid #000;
            padding: 12px;
            text-align: center;
        }

        .sanpham th {
            background-color: #f2f2f2;
        }
        .filter-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center; 
            margin-top: 20px;
        }
        .filter-comboboxes input[type="text"] {
            padding: 10px;
            font-size: 16px; 
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 200px;
            outline: none;
            transition: all 0.3s ease-in-out; 
            font-family: 'Arial', sans-serif;
        }

        .filter-comboboxes input[type="text"]::placeholder {
            color: #c7c7c7; 
        }
        .filter-comboboxes {
            display: flex;
            gap: 20px;
        }

        .filter-comboboxes select {
            padding: 8px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .button-group {
            display: flex;
            justify-content: flex-end; 
            width: 100%;
            margin-top: 20px;
            max-width: 800px;
        }

        .btn {
            padding: 10px 20px;
            font-size: 16px;
            margin-left: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .product-details {
            font-weight: bold;
        }
        .tablechitiet {
            width: 400px;
            padding: 15px;
            border-radius: 5px;
            margin: 5px auto;
            text-align: center;

        }
        .no-products {
            text-align: center;
            margin: 20px 0;
            font-size: 18px;
            color: #555;
            font-weight: bold;
        }
        .product{
            width: 50%;
        }
        /* Header POCO */
        .poco-header {
            background-color: red;
            color: white;
        }

        .poco-title {
            font-family: cursive;
            color: white;
        }

        .poco-user {
            color: white;
            text-decoration: none;
        }

        /* Tabs */
        

        .header-tabs {
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* 4 cột đều nhau */
             /* đỏ theo hình */
            padding: 10px 0;
        }

        .header-tabs a {
            text-align: center;
            padding: 10px 0;
            text-decoration: none;
            color: white;
            font-weight: 500;
            transition: background 0.3s;
            display: block;
            white-space: pre-line; /* cho phép xuống dòng như "Sản phẩm" */
        }

        .header-tabs a.active {
            border-bottom: 3px solid white;
            font-weight: bold;
        }

        .header-tabs a:hover {
            background-color: #e03e3e;
        }

    </style>
</head>

<body class="text-gray-800">

    <div class="bg-red-500 text-white px-6 py-4 flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="flex items-center">
            <img src="{{ asset('banner/logo.png') }}" alt="Banner" class="w-auto h-[60px] object-contain">
            <img src="{{ asset('banner/duongthang.png') }}" class="w-auto h-[60px] object-contain">
            <span class="title"> NHÂN VIÊN</span>
        </div>

        {{-- Icon --}}
        <div class="flex gap-6 text-2xl relative">
        <a href="" class="text-white hover:text-yellow-300 transition flex items-center gap-2"><i class="fa-regular fa-bell"></i></a>
            <div class="relative">
                <button id="user-button" class="text-white hover:text-yellow-300 transition flex items-center gap-2">
                    <i class="fas fa-user"></i>
                    @auth <span class="text-sm font-medium">{{ Auth::user()->name }}</span> @endauth
                </button>
                <div id="user-dropdown" class="absolute right-0 mt-3 w-48 bg-white text-black rounded-xl shadow-lg hidden z-50">
                    @auth
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm hover:bg-yellow-100 hover:text-yellow-700 transition">Đăng xuất</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white">
        <div class="container-fluid tab-bar">
        <div class="header-tabs mt-2">
            <a href="{{ url('/nhanvien') }}" class="{{ request()->is('nhanvien*') ? 'active' : '' }}">Sản phẩm</a>
            <a href="{{ url('/khachhang') }}" class="{{ request()->is('khachhang*') ? 'active' : '' }}">Khách hàng</a>
            <a href="{{ url('/don-hang') }}" class="{{ request()->is('don-hang*') ? 'active' : '' }}">Đơn hàng</a>
            <a href="{{ url('/doanhthu') }}" class="{{ request()->is('doanhthu*') ? 'active' : '' }}">Báo cáo doanh thu</a>
        </div>

        </div>
    </div>

    {{-- CONTENT --}}
    <div class="container mt-4">
        @yield('content')
    </div>
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
