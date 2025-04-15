<x-store-layout>
<div class="container">
<h2 style="font-size: 32px; text-align: center; font-weight: bold;">
  Chỉnh sửa thông tin cá nhân
</h2>
@if(session('success'))
    <div id="success-alert" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            }
        }, 2500);
    </script>
@endif

    

    <form method="POST" action="{{ route('khachhang.capnhat') }}">
        @csrf

        <div class="form-group">
            <label>Tên khách hàng</label>
            <input type="text" name="tenKH" class="form-control" value="{{ old('tenKH', $khachhang->tenKH) }}">
        </div>

        <div class="form-group">
            <label>Giới tính</label>
            <select name="gioiTinh" class="form-control">
                <option value="1" {{ $khachhang->gioiTinh ? 'selected' : '' }}>Nam</option>
                <option value="0" {{ !$khachhang->gioiTinh ? 'selected' : '' }}>Nữ</option>
            </select>
        </div>

        <div class="form-group">
            <label>Ngày sinh</label>
            <input type="date" name="ngaySinh" class="form-control" value="{{ old('ngaySinh', $khachhang->ngaySinh) }}">
        </div>

        <div class="form-group">
            <label>Địa chỉ</label>
            <input type="text" name="diaChi" class="form-control" value="{{ old('diaChi', $khachhang->diaChi) }}">
        </div>

        <div class="form-group">
            <label>Số điện thoại</label>
            <input type="text" name="soDienThoai" class="form-control" value="{{ old('soDienThoai', $khachhang->soDienThoai) }}">
        </div>

        <div class="d-flex justify-content-between mt-3">
  <button type="submit" class="btn btn-primary">Cập nhật</button>
  <a href="{{ route('home') }}" class="btn btn-primary">Quay lại</a>
</div>
    </form>
</div>
</x-store-layout>