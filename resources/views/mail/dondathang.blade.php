<html>
    <head>
        <style>
            .book-table
            {
                border-collapse:collapse;
            }
            .book-table tr th
            {
                text-align:center;
            }
            .book-table tr th, .book-table tr td
            {
                border:1px solid #000;
                padding:3px;
            }
        </style>
    </head>
    <body>
    <div style='text-align:center;font-weight:bold;color:#15c;'>
        THÔNG TIN ĐƠN HÀNG
    </div>

    <table class='book-table' style='margin:0 auto; width:70%'>
        <thead>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Số lượng</th>
            <th>Đơn giá</th>
        </thead>
        <tbody>
            @php
                $tongTien = 0;
            @endphp
            @foreach($data as $key=>$row)
                <tr>
                    <td align='center'>{{$key+1}}</td>
                    <td>{{$row->tenSP}}</td>
                    <td align='center'>{{$row->soLuong}}</td>
                    <td align='center'>{{number_format($row->giaBan,0,',','.')}}đ</td>
                </tr>
                @php
                    $tongTien +=$row->soLuong*$row->giaBan;
                @endphp
            @endforeach
            <tr>
                <td colspan='3' align='center'><b>Tổng cộng</b></td>
                <td align='center'><b>{{number_format($tongTien,0,',','.')}}đ</b></td>
            </tr>
        </tbody>
    </table>
</body>
</html>