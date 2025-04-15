@extends('layouts.layout')

@section('content')

    <!-- Hiển thị thông báo thành công hoặc thất bại -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- FORM LỌC KHÁCH HÀNG -->
    <form method="GET" action="{{ route('customers.index') }}">
        <div class="border p-3 mb-3">
            <div class="d-flex justify-content-between">
                <div>
                    <button type="button" class="btn btn-outline-primary btn-sm">Bộ lọc</button>
                    <button type="submit" name="filter" value="frequent" class="btn btn-outline-secondary btn-sm">Mua thường xuyên</button>
                    <button type="submit" name="filter" value="inactive" class="btn btn-outline-secondary btn-sm">Lâu chưa mua</button>
                </div>
            </div>

            <div class="d-flex gap-2 mt-3 flex-wrap">
                <input class="form-control w-auto" name="maKH" placeholder="Mã KH (ID)" value="{{ request('maKH') }}">
                <input class="form-control w-auto" name="tenKH" placeholder="Tên khách hàng" value="{{ request('tenKH') }}">
                <select name="level" class="form-control w-auto">
                    <option value="">Cấp độ</option>
                    <option value="Thành viên" {{ request('level') == 'Thành viên' ? 'selected' : '' }}>Thành viên</option>
                    <option value="Bạc" {{ request('level') == 'Bạc' ? 'selected' : '' }}>Bạc</option>
                    <option value="Vàng" {{ request('level') == 'Vàng' ? 'selected' : '' }}>Vàng</option>
                    <option value="Kim Cương" {{ request('level') == 'Kim Cương' ? 'selected' : '' }}>Kim Cương</option>
                </select>

                <div class="d-flex align-items-center gap-2">
                    <button class="btn btn-outline-success">Lọc</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary btn-sm">Làm mới</a>
                    <a href="{{ route('customers.export') }}" class="btn btn-primary btn-sm">Xuất file</a>
                </div>
            </div>
        </div>
    </form>

    <!-- FORM THÊM MÃ GIẢM GIÁ QUA FILE -->
    <div class="d-flex justify-content-end mb-3">
        <form action="{{ route('discount.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2">
            @csrf
            <input type="file" name="file" accept=".xlsx, .xls" required class="form-control w-auto">
            <button type="submit" class="btn btn-success btn-sm">Thêm mã giảm giá</button>
        </form>
    </div>

    <!-- BẢNG HIỂN THỊ DANH SÁCH KHÁCH HÀNG -->
    <table class="table table-bordered customer-table">
        <thead class="table-light">
            <tr>
                <th><input type="checkbox"></th>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Cấp độ</th>
                <th>Lần mua</th>
                <th>Số lượng</th>
                <th>Điểm tích lũy</th>
                <th>Mã giảm giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $cus)
                <tr>
                    <th><input type="checkbox"></th>
                    <td>{{ $cus->maKH }}</td>
                    <td>{{ $cus->tenKH }}</td>
                    <td>{{ $cus->cap_do }}</td>
                    <td>{{ $cus->donhangs_count }}</td>
                    <td>{{ $cus->tong_soluong ?? 0 }}</td>
                    <td>{{ $cus->diemTichLuy }}</td>
                    <td>
                        @if($cus->maGiamGiasPhuHop->isNotEmpty())
                            <select class="form-select form-select-sm">
                                @foreach($cus->maGiamGiasPhuHop as $mg)
                                    <option value="{{ $mg->maGG }}">{{ $mg->maGG }} - {{ $mg->moTaMaGiamGia }}</option>
                                @endforeach
                            </select>
                        @else
                            <span class="text-muted">Không có</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

@endsection
