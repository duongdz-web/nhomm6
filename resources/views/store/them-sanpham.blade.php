@extends("layouts.nhanvien-layout")
@section("title","Thêm sản phẩm")
@section("content")
<style>

     .form-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }
    .add-table {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .add-table th, .edit-table td {
        padding: 12px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
    }

    .add-table th {
        background-color: #f1f1f1;
        width: 30%;
        text-align: left;
    }
</style>
<div class="form-title">THÊM SẢN PHẨM</div>

<form action="{{ route('nhanvien.sanpham.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <table class="table add-table">
        <tr>
            <th>Mã SP</th>
            <td><input type="text" name="maSP" class="form-control" required></td>
        </tr>
        <tr>
            <th>Tên SP</th>
            <td><input type="text" name="tenSP" class="form-control" required></td>
        </tr>
        <tr>
            <th>Giá nhập</th>
            <td><input type="number" name="giaNhap" class="form-control" required></td>
        </tr>
        <tr>
            <th>Giá bán</th>
            <td><input type="number" name="giaBan" class="form-control" required></td>
        </tr>
        <tr>
            <th>Số lượng tồn kho</th>
            <td><input type="number" name="soLuongTonKho" class="form-control" required></td>
        </tr>
        <tr>
            <th>Ngày nhập</th>
            <td><input type="date" name="ngayNhap" class="form-control" required></td>
        </tr>
        <tr>
            <th>Đơn vị</th>
            <td><input type="text" name="donVi" class="form-control" required></td>
        </tr>
        <tr>
            <th>Mã loại</th>
            <td><input type="text" name="maLoai" class="form-control" required></td>
        </tr>
        <tr>
            <th>Hình ảnh</th>
            <td><input type="file" name="hinhanh" class="form-control"></td>
        </tr>
        <tr>
            <td colspan="2" class="text-center">
                <button type="submit" class="btn btn-success">Lưu sản phẩm</button>
                <a href="{{ route('nhanvien.sanpham') }}" class="btn btn-secondary">Quay lại</a>
            </td>
        </tr>
    </table>
</form>

@endsection
