<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Đơn hàng giao thành công</title>
</head>
<body style="font-family: Arial, sans-serif; padding: 30px; color: #000000;">
    <table width="600" align="center" style="background-color: #ffffff; padding: 20px; border-radius: 8px; border: 10px solid #910a0c;">
        <tr>
            <td align="center">
                <img src="https://i.imgur.com/54mhjSy.png" alt="Logo cửa hàng" style="width: 120px; ">
            </td>
        </tr>
        <tr>
            <td>
                <h2 style="color: #910a0c;">Cảm ơn bạn đã mua hàng, {{ $hoTen }}!</h2>
                <p>Chúng tôi rất vui thông báo rằng đơn hàng của bạn đã được giao thành công vào ngày {{ $ngayGiao }}.</p>

                <h4>Thông tin đơn hàng:</h4>
                <ul style="list-style-type: none; padding: 0;">
                    <li><strong>Mã đơn hàng:</strong> {{ $maDonHang }}  <a href="{{ url('/don-dat-hang/' . $maDonHang) }}" style="color: #688f4e; font-weight: bold;">Xem chi tiết</a></li> 
                    <li><strong>Ngày đặt:</strong> {{ $ngayDatHang }}</li>
                    <li><strong>Tổng tiền thanh toán:</strong> {{ number_format($tongTien, 0, ',', '.') }} VND</li>
                    <li><strong>Địa chỉ giao hàng:</strong> {{ $diaChi }}</li>
                </ul>

                <p>Nếu có bất kỳ thắc mắc nào, vui lòng liên hệ với bộ phận CSKH của chúng tôi.</p>

                <div style="margin: 30px 0; text-align: center;">
                    <a href="http://127.0.0.1:8000" style="background-color: #ffbe24; color: black; padding: 12px 20px; text-decoration: none; border-radius: 5px; display: inline-block;">
                        Quay lại cửa hàng
                    </a>
                </div>

                <p style="font-size: 13px; color: #999;text-align: center;">Cửa hàng POCO - Chăm sóc tận tâm, giao hàng đúng hẹn.</p>
            </td>
        </tr>
    </table>
</body>
</html>
