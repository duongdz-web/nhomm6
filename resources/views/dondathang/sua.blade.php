<x-store-layout>
    <div class="container py-4 d-flex justify-content-center">
        <div class="card shadow-sm rounded-3 w-100 position-relative" style="max-width: 600px;">
            {{-- Nút X quay lại --}}
            <a href="{{ route('home') }}" class="btn btn-sm btn-light position-absolute" style="top: 10px; right: 10px;">
                &times;
            </a>


            <div class="card-body p-4 pt-3">
                <h2 class="text-center mb-4 fw-bold" style="font-size: 26px;">
                    Thông tin cá nhân
                </h2>


                @if(session('success'))
                    <div id="success-alert" class="alert alert-success text-center py-2">
                        {{ session('success') }}
                    </div>


                    <script>
                        setTimeout(function () {
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


                    <div class="mb-3">
                        <label class="form-label">Tên khách hàng</label>
                        <input type="text" name="tenKH" class="form-control" value="{{ old('tenKH', $khachhang->tenKH) }}" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Giới tính</label>
                        <select name="gioiTinh" class="form-select" required>
                            <option value="1" {{ $khachhang->gioiTinh ? 'selected' : '' }}>Nam</option>
                            <option value="0" {{ !$khachhang->gioiTinh ? 'selected' : '' }}>Nữ</option>
                        </select>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Ngày sinh</label>
                        <input type="date" name="ngaySinh" class="form-control" value="{{ old('ngaySinh', $khachhang->ngaySinh) }}" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" name="diaChi" class="form-control" value="{{ old('diaChi', $khachhang->diaChi) }}" required>
                    </div>


                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" name="soDienThoai" class="form-control" value="{{ old('soDienThoai', $khachhang->soDienThoai) }}" required>
                    </div>


                    <div class="d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-primary px-4">Cập nhật</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-store-layout>



