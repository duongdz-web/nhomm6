@extends('layouts.layout')

@section('content')
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-3">
        {{ session('success') }}
    </div>
@endif

<div class="p-4">

    <form method="GET" class="bg-gray-100 p-4 rounded-lg mb-4">
        <div class="flex flex-wrap gap-3 mb-4">
            <input type="text" name="maDH" placeholder="Mã đơn" value="{{ request('maDH') }}"
                class="border rounded p-2 w-40">
            <select name="tinhTrang" class="border rounded p-2 w-40">
                <option value="">Trạng thái</option>
                <option value="Chờ xử lý">Chờ xử lý</option>
                <option value="Đang vận chuyển">Đang vận chuyển</option>
                <option value="Đang đóng gói">Đang đóng gói</option>
                <option value="Đã hủy">Đã hủy</option>
                <option value="Đã giao">Đã giao</option>
            </select>
            <input type="date" name="TuNgay" class="border rounded p-2" value="{{ request('TuNgay') }}">
            <input type="date" name="DenNgay" class="border rounded p-2" value="{{ request('DenNgay') }}">
        </div>

        <div class="flex items-center gap-3">
            <button class="btn btn-outline-success">Lọc</button>
            <a href="{{ route('donhang.index') }}" class="btn btn-secondary btn-sm">Làm mới</a>
            <a href="{{ route('donhang.export') }}" class="btn btn-primary btn-sm">Xuất file</a>
        </div>
    </form>

    <table class="w-full border text-sm text-left border-collapse">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2 border">Mã đơn</th>
                <th class="p-2 border">Khách hàng</th>
                <th class="p-2 border">Địa chỉ</th>
                <th class="p-2 border">Ngày đặt</th>
                <th class="p-2 border">Tên sản phẩm</th>
                <th class="p-2 border text-center">Số lượng</th>
                <th class="p-2 border">Tổng tiền</th>
                <th class="p-2 border">Trạng thái</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($donhang as $dh)
            <tr class="border-t">
                <td class="p-2 border">{{ $dh->maDH }}</td>
                <td class="p-2 border">{{ $dh->tenKH }}</td>
                <td class="p-2 border">{{ $dh->diaChi }}</td>
                <td class="p-2 border">{{ $dh->ngayLap }}</td>
                <td class="p-2 border">
                    @foreach ($dh->chitiet as $ct)
                        <div>{{ $ct->tenSP }}</div>
                    @endforeach
                </td>
                <td class="p-2 border text-center">
                    @foreach ($dh->chitiet as $ct)
                        <div>{{ $ct->soLuong }}</div>
                    @endforeach
                </td>
                <td class="p-2 border">
                    @foreach ($dh->chitiet as $ct)
                        <div>{{ number_format($ct->giaBan * $ct->soLuong, 0, ',', '.') }}</div>
                    @endforeach
                </td>
                <td class="p-2 border">
    <form action="{{ route('donhang.updateTrangThai', $dh->maDH) }}" method="POST">
        @csrf
        @method('PUT')
        <select name="tinhTrang" onchange="this.form.submit()" class="border rounded p-1 text-sm">
            <option value="Chờ xử lý" {{ $dh->tinhTrang == 'Chờ xử lý' ? 'selected' : '' }}>Chờ xử lý</option>
            <option value="Đang đóng gói" {{ $dh->tinhTrang == 'Đang đóng gói' ? 'selected' : '' }}>Đang đóng gói</option>
            <option value="Đang vận chuyển" {{ $dh->tinhTrang == 'Đang vận chuyển' ? 'selected' : '' }}>Đang vận chuyển</option>
            <option value="Đã giao" {{ $dh->tinhTrang == 'Đã giao' ? 'selected' : '' }}>Đã giao</option>
            <option value="Đã hủy" {{ $dh->tinhTrang == 'Đã hủy' ? 'selected' : '' }}>Đã hủy</option>
        </select>
    </form>
</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
