<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <header>
        <h1>POCO</h1>
        <input type="text" placeholder="Bạn tìm kiếm gì hôm nay?" />
    </header>
    
    <nav>
        <ul>
            <li><a href="#">Đồ ăn</a></li>
            <li><a href="#">Đồ uống</a></li>
            <li><a href="#">Tiện ích gia đình</a></li>
            <li><a href="#">Hàng gia dụng</a></li>
            <li><a href="#">Văn phòng phẩm</a></li>
            <li><a href="#">Đồ chơi</a></li>
            <li><a href="#">Sản phẩm làm đẹp</a></li>
            <li><a href="#">Thực phẩm đóng hộp</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer>
        <p>© 2025 POCO</p>
    </footer>
</body>
</html>
