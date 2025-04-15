@extends("layouts.nhanvien-layout")
@section("title","Sản phẩm")
@section("content")

<style>
    table.table-bordered {
        border: 1px solid #000;
    }

    table.table-bordered th,
    table.table-bordered td {
        border: 1px solid #000 !important;
    }
</style>
<h1><center>QUẢN LÝ SẢN PHẨM</center></h1>
<form action="{{ route('nhanvien.sanpham.import') }}" method="POST" enctype="multipart/form-data" class="d-inline-block" style="margin-left:10px;">
        @csrf
        <input type="file" name="file" class="form-control-file d-inline" style="width:200px;" required>
        <button type="submit" class="btn btn-info">
            <i class="fa fa-upload"></i> Tải lên Excel
        </button>
        <a href="{{ route('nhanvien.sanpham.export') }}" class="btn btn-primary">
            <i class="fa fa-file-excel"></i> Xuất Excel
        </a>
    </form>

<div class="mb-2 text-end">
    <a href="{{ route('nhanvien.sanpham.create') }}" class="btn btn-success">
        <i></i> Thêm sản phẩm
    </a>
</div>
<!-- Form Tìm kiếm -->
<form action="{{ route('nhanvien.sanpham') }}" method="GET" class="mb-4 d-flex" style="gap: 10px;">
    <input type="text" name="maSP" class="form-control" placeholder="Tìm mã sản phẩm" value="{{ request('maSP') }}">
    <input type="text" name="tenSP" class="form-control" placeholder="Tìm tên sản phẩm" value="{{ request('tenSP') }}">
    <button type="submit" class="btn btn-success rounded">
        <i class="fa fa-filter"></i> Lọc
    </button>
    <a href="{{ route('nhanvien.sanpham') }}" class="btn btn-secondary rounded">Làm mới</a>
</form>
<table class="table table-bordered text-center">
    <thead>
        <tr>
            <th>Mã sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Giá nhập</th>
            <th>Giá bán</th>
            <th>Loại sản phẩm</th>
            <th>Số lượng tồn kho</th>
            <th>Ngày nhập</th>
            <th>Đơn vị</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        @foreach($sanpham as $sp)
        <tr>
            <td>{{ $sp->maSP }}</td>
            <td>{{ $sp->tenSP }}</td>
            <td>{{ number_format($sp->giaNhap, 0, '.', '.') }}</td>
            <td>{{ number_format($sp->giaBan, 0, '.', '.') }}</td>
            <td>{{ $sp->maLoai }}</td>
            <td>{{ $sp->soLuongTonKho }}</td>
            <td>{{ $sp->ngayNhap }}</td>
            <td>{{ $sp->donVi }}</td>
            <td>
                <img src="{{ asset('sanpham/'.$sp->hinhanh) }}" width="80px" height="80px" />
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('nhanvien.sanpham.edit', $sp->maSP) }}" class="btn btn-warning btn-sm">Sửa</a>
                    
                    <form action="{{ route('nhanvien.sanpham.delete', $sp->maSP) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </div>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endsection
