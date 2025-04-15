<x-store-layout>
    <x-slot name='title'>Đơn đặt hàng</x-slot>

    <div class="container mx-auto py-8">
    {{-- Thanh lọc tình trạng đơn --}}
<div class="bg-red-700 text-white rounded-xl shadow mb-6 px-4 py-3 flex flex-wrap justify-center gap-4 text-sm font-medium">
    @php
        $tinhTrangList = [
            'Chờ xử lý' => 'fa-spinner',
            'Đang đóng gói' => 'fa-box',
            'Đang vận chuyển' => 'fa-truck',
            'Đã giao' => 'fa-check-circle',
            'Đã huỷ' => 'fa-times-circle',
        ];
        $activeTinhTrang = request('tinhtrang');
    @endphp

    @foreach ($tinhTrangList as $label => $icon)
        <a href="{{ route('dondathang.index', ['tinhtrang' => $label]) }}"
           class="flex items-center gap-2 px-4 py-2 rounded-full border border-white hover:bg-white hover:text-red-700 transition {{ $activeTinhTrang === $label ? 'bg-white text-red-700 font-bold' : '' }}">
            <i class="fas {{ $icon }}"></i> {{ $label }}
        </a>
    @endforeach

    @if($activeTinhTrang)
        <a href="{{ route('dondathang.index') }}" class="ml-4 underline hover:text-yellow-300 text-sm">Xem tất cả</a>
    @endif
</div>
    @if(session('success'))
    <div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 rounded">
        {{ session('success') }}
    </div>

    <script>
        // Tự ẩn thông báo sau 2 giây
        setTimeout(function() {
            var alert = document.getElementById('success-alert');
            if (alert) {
                alert.style.display = 'none';
            }
        }, 2000); // 2000 = 2 giây
    </script>
@endif
   

    @if($donDatHangs->isEmpty())
        <div class="bg-yellow-50 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded text-center">
            <p class="font-medium">Bạn chưa có đơn đặt hàng nào.</p>
        </div>
    @else
        <div class="flex flex-wrap justify-start gap-6">
            @foreach($donDatHangs as $don)
                @php
                    $spDaiDien = null;
                    if ($don->chitietdondat && $don->chitietdondat->first()) {
                        $spDaiDien = $don->chitietdondat->first()->sanpham;
                    }
                @endphp

                <div class="w-full sm:w-[22rem] bg-white rounded-xl shadow hover:shadow-md border border-gray-100 p-4 flex flex-col gap-4">
                    {{-- Ảnh sản phẩm --}}
                    <div class="w-full h-40 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                        @if($spDaiDien && $spDaiDien->hinh)
                            <img src="{{ asset('storage/' . $spDaiDien->hinh) }}" class="object-cover w-full h-full">
                        @else
                            <span class="text-gray-400 text-sm">Không có ảnh</span>
                        @endif
                    </div>

                    {{-- Nội dung đơn --}}
                    <div>
                        <h3 class="text-base font-semibold text-gray-800">🧾 Mã đơn: {{ $don->maDH }}</h3>
                        <p class="text-base font-semibold text-gray-600"> Ngày đặt: {{ $don->ngayLap->format('d/m/Y') }}</p>
                        <p class="text-base font-semibold text-gray-600"> Trạng thái: 
                            <span class="font-medium {{ $don->tinhTrang == 'Đã giao' ? 'text-green-600' : 'text-blue-600' }}">
                                {{ $don->tinhTrang }}
                            </span>
                        </p>
                        <p class="text-base font-semibold text-gray-600"> Tổng tiền: 
    <span class="font-medium text-red-600">
        {{ number_format($don->tongTienThanhToan, 0, ',', '.') }}₫
    </span>
</p>
                         <p class="text-base font-semibold text-gray-600"> Hình thức: 
    <span class="font-medium text-indigo-600">
        {{ $don->tinhTrangThanhToan== 'Đã thanh toán' ? 'Thanh toán bằng QR' : 'Thanh toán khi nhận hàng' }}
    </span>
</p>
                    </div>

                    {{-- Nút chức năng --}}
                    <div class="flex gap-2 justify-between mt-auto">
                        <a href="{{ route('dondathang.chitiet', $don->maDH) }}" class="flex-1 text-center px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700 transition">
                            Xem chi tiết
                        </a>
                        @if($don->tinhTrang == 'Chờ xử lý')
    <form method="POST" action="{{ route('dondathang.huy', $don->maDH) }}" class="flex-1"
          onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng?');">
        @csrf
        @method('PUT')
        <button type="submit" class="w-full px-4 py-2 bg-red-500 text-white text-sm rounded-md hover:bg-red-600 transition">
            Hủy đơn
        </button>
    </form>
@endif
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</x-store-layout>