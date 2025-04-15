@extends("layouts.nhanvien-layout")
@section("title", "Sửa sản phẩm")
@section("content")

<style>
    .edit-table {
        max-width: 800px;
        margin: auto;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .edit-table th, .edit-table td {
        padding: 12px;
        vertical-align: middle;
        border: 1px solid #dee2e6;
    }

    .edit-table th {
        background-color: #f1f1f1;
        width: 30%;
        text-align: left;
    }

    .form-control, .btn {
        border-radius: 8px;
    }

    .form-title {
        text-align: center;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .image-preview {
        width: 100px;
        border-radius: 8px;
        border: 1px solid #ccc;
    }
</style>

<div class="container mt-4">
    <div class="form-title">SỬA THÔNG TIN SẢN PHẨM</div>

    <form action="{{ route('nhanvien.sanpham.update', $sanpham->maSP) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table class="table edit-table">
            <tr>
                <th>Mã sản phẩm</th>
                <td><input type="text" name="maSP" class="form-control" value="{{ $sanpham->maSP }}" readonly></td>
            </tr>
            <tr>
                <th>Tên sản phẩm</th>
                <td><input type="text" name="tenSP" class="form-control" value="{{ $sanpham->tenSP }}" required></td>
            </tr>
            <tr>
                <th>Giá nhập</th>
                <td><input type="number" name="giaNhap" class="form-control" value="{{ $sanpham->giaNhap }}" required></td>
            </tr>
            <tr>
                <th>Giá bán</th>
                <td><input type="number" name="giaBan" class="form-control" value="{{ $sanpham->giaBan }}" required></td>
            </tr>
            <tr>
                <th>Số lượng tồn kho</th>
                <td><input type="number" name="soLuongTonKho" class="form-control" value="{{ $sanpham->soLuongTonKho }}" required></td>
            </tr>
            <tr>
                <th>Ngày nhập</th>
                <td><input type="date" name="ngayNhap" class="form-control" value="{{ $sanpham->ngayNhap }}" required></td>
            </tr>
            <tr>
                <th>Đơn vị</th>
                <td><input type="text" name="donVi" class="form-control" value="{{ $sanpham->donVi }}" required></td>
            </tr>
            <tr>
                <th>Mã loại</th>
                <td><input type="text" name="maLoai" class="form-control" value="{{ $sanpham->maLoai }}" required></td>
            </tr>
            <tr>
                <th>Hình ảnh hiện tại</th>
                <td><img src="{{ asset('sanpham/' . $sanpham->hinhanh) }}" class="image-preview" alt="Hình ảnh sản phẩm"></td>
            </tr>
            <tr>
                <th>Cập nhật hình ảnh mới</th>
                <td><input type="file" name="hinhanh" class="form-control"></td>
            </tr>
        </table>

        <div class="d-flex justify-content-center mt-4 gap-3">
            <button type="submit" class="btn btn-success px-4">Lưu thay đổi</button>
            <a href="{{ route('nhanvien.sanpham') }}" class="btn btn-secondary px-4">Hủy</a>
        </div>
    </form>
</div>

@endsection
