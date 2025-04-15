<x-nhanvien-layout>
<div class="p-4 bg-white min-h-screen">
    <h1 class="text-3xl font-bold text-center text-blue-900 mb-6">BÁO CÁO DOANH THU</h1>

    {{-- Bộ lọc --}}
    <form method="GET" action="{{ route('nhanvien.doanhthu') }}" class="grid grid-cols-6 gap-4 items-end mb-6">
    {{-- Từ ngày --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Từ ngày</label>
        <input type="date" id="start_date" name="start_date" value="{{ request('start_date') }}" class="form-input mt-1 p-2 rounded border border-gray-300 w-full" onchange="formatDate(this)">
    </div>

    {{-- Đến ngày --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Đến ngày</label>
        <input type="date" id="end_date" name="end_date" value="{{ request('end_date') }}" class="form-input mt-1 p-2 rounded border border-gray-300 w-full" onchange="formatDate(this)">
    </div>


    {{-- Năm --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Năm</label>
        <input type="number" name="year" value="{{ request('year') }}"
            placeholder="Nhập năm..."
            max="{{ date('Y') }}" min="2020"
            class="form-input mt-1 p-2 rounded border border-gray-300 w-full" />

    </div>

    {{-- Quý --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Quý</label>
        <select name="quarter" class="form-select mt-1 p-2 rounded border border-gray-300 w-full">
            <option value="">Cả năm</option>
            <option value="1" {{ request('quarter') == '1' ? 'selected' : '' }}>Quý 1</option>
            <option value="2" {{ request('quarter') == '2' ? 'selected' : '' }}>Quý 2</option>
            <option value="3" {{ request('quarter') == '3' ? 'selected' : '' }}>Quý 3</option>
            <option value="4" {{ request('quarter') == '4' ? 'selected' : '' }}>Quý 4</option>
        </select>
    </div>

    {{-- Loại sản phẩm --}}
    <div>
        <label class="block text-sm font-medium text-gray-700">Loại sản phẩm</label>
        <select name="category" class="form-select mt-1 p-2 rounded border border-gray-300 w-full">
            <option value="">Tất cả</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->maLoai }}" {{ request('category') == $cat->maLoai ? 'selected' : '' }}>
                    {{ $cat->tenLoai }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Nút lọc --}}
    <div class="flex items-end space-x-2">
        <button type="submit" class="bg-pink-500 hover:bg-pink-600 text-white font-bold py-2 px-6 rounded w-full">
            Lọc
        </button>
        <a href="{{ route('nhanvien.doanhthu') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded w-full text-center">
            Reset
        </a>
    </div>
</form>



    {{-- Tổng doanh thu và số lượng --}}
    <div class="grid grid-cols-2 gap-6 mb-6">
        <div class="bg-blue-300 text-white text-center p-6 rounded-xl text-3xl font-bold">
            {{ number_format($tongDoanhThu / 1_000_000, 2) }}M <br>
            <span class="text-lg font-normal">Tổng doanh thu</span>
        </div>
        <div class="bg-indigo-300 text-white text-center p-6 rounded-xl text-3xl font-bold">
            {{ number_format($tongSoLuong / 1000, 2) }}K <br>
            <span class="text-lg font-normal">Số lượng đã bán</span>
        </div>
    </div>

    {{-- Biểu đồ --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Doanh thu theo tháng --}}
        <div class="bg-white p-4 rounded-2xl shadow-md flex flex-col items-center justify-center">
            <h2 class="text-lg font-bold mb-4 text-blue-800 text-center">Doanh thu theo tháng</h2>
            <div class="flex justify-center w-full h-[200px]">
                <canvas id="doanhThuThang" class="max-w-full max-h-full"></canvas>
            </div>
        </div>

        {{-- Doanh thu theo loại sản phẩm --}}
        <div class="bg-white p-4 rounded-2xl shadow-md flex flex-col items-center justify-center">
            <h2 class="text-lg font-bold mb-4 text-blue-800 text-center">Doanh thu theo loại sản phẩm</h2>
            <div class="flex justify-center w-full h-[200px]">
                <canvas id="doanhThuLoai" class="max-w-full max-h-full"></canvas>
            </div>
        </div>

        {{-- Tổng quan trạng thái đơn hàng --}}
        <div class="bg-white p-4 rounded-2xl shadow-md flex flex-col items-center justify-center">
            <h2 class="text-lg font-bold mb-4 text-blue-800 text-center">Tổng quan trạng thái đơn hàng</h2>
            <div class="flex justify-center w-full h-[200px]">
                <canvas id="trangThaiDonHang" class="max-w-full max-h-full"></canvas>
            </div>
        </div>

        {{-- Doanh thu theo quý --}}
        <div class="bg-white p-4 rounded-2xl shadow-md flex flex-col items-center justify-center">
            <h2 class="text-lg font-bold mb-4 text-blue-800 text-center">Doanh thu theo quý</h2>
            <div class="flex justify-center w-full h-[200px]">
                <canvas id="doanhThuQuy" class="max-w-full max-h-full"></canvas>
            </div>
        </div>
    </div>

    {{-- ChartJS CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const doanhThuThang = @json($doanhThuThang);
        const doanhThuLoai = @json($doanhThuLoai);
        const doanhThuQuy = @json($doanhThuQuy);
        const trangThaiDonHang = @json($trangThaiDonHang);

        new Chart(document.getElementById('doanhThuThang'), {
            type: 'line',
            data: {
                labels: Object.keys(doanhThuThang),
                datasets: [{
                    label: 'Doanh thu',
                    data: Object.values(doanhThuThang),
                    borderColor: 'rgb(54, 162, 235)',
                    fill: false
                }]
            }
        });

        new Chart(document.getElementById('doanhThuLoai'), {
            type: 'bar',
            data: {
                labels: Object.keys(doanhThuLoai),
                datasets: [{
                    label: 'Doanh thu',
                    data: Object.values(doanhThuLoai),
                    backgroundColor: 'rgba(75, 192, 192, 0.6)'
                }]
            },
            options: {
                indexAxis: 'y'
            }
        });

        new Chart(document.getElementById('doanhThuQuy'), {
            type: 'bar',
            data: {
                labels: Object.keys(doanhThuQuy),
                datasets: [{
                    label: 'Doanh thu',
                    data: Object.values(doanhThuQuy),
                    backgroundColor: 'rgba(153, 102, 255, 0.6)'
                }]
            }
        });

        new Chart(document.getElementById('trangThaiDonHang'), {
            type: 'doughnut',
            data: {
                labels: Object.keys(trangThaiDonHang),
                datasets: [{
                    label: 'Số đơn',
                    data: Object.values(trangThaiDonHang),
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.6)',
                        'rgba(54, 162, 235, 0.6)',
                        'rgba(255, 206, 86, 0.6)',
                        'rgba(75, 192, 192, 0.6)',
                        'rgba(153, 102, 255, 0.6)'
                    ]
                }]
            }
        });
    </script>
</div>
</x-nhanvien-layout>
