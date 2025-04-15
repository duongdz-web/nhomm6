<x-store-layout>
    <style>
        .address-item input[type="radio"] {
            margin-right: 15px;
            accent-color: #910a0c; /* Màu đỏ giống bản gốc */
        }
        .address-item .info {
            flex-grow: 1;
        }
        .address-item .info p {
        margin: 5px 0;
        }
        .address-item .info span {
        color: #688f4e; 
        font-weight: bold;
        border: 1px solid #688f4e;
        border-radius: 5px;
        padding: 3px;
        background-color: white;
        }
        .btn-warning {
            background-color: #ffbe24;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-warning:hover {
            background-color: #688f4e;
            color: white;
        }
        .btn-danger{
            background-color: #910a0c;
            color:white;
            border: none;
            padding: 8px 12px;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-danger:hover {
            background-color: #688f4e;
            color: white;
        }
        .btn-outline-danger {
            background-color: white;
            color: #910a0c;
            border: 3px solid #910a0c;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            display: block;
            margin: 25px auto;
            text-align: center;
            width: 230px;
        }
        .btn-outline-danger:hover {
            background-color: #910a0c;
            color: white;
        }
        .container {
            max-width: 700px;
            margin: 30px auto;

        }
        .address-item {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .button-container {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
        }
    </style>
    <div class="container">
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: '{{ session("success") }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                });
            </script>
        @endif
        @foreach ($addresses as $address)
            <div class="address-item mb-3 p-3 shadow-sm d-flex justify-content-between align-items-center bg-white rounded">
                <input type="radio" name="default-address" value="{{ $address->maDiaChi }}" 
                    onchange="selectAddress('{{ $address->maDiaChi }}')">
                <div class="info flex-grow-1 ms-3">
                    <p><strong>{{ $address->hoTen }}</strong> | {{ $address->soDienThoai }}</p>
                    <p>{{ $address->diaChi }}, {{ $address->phuong }}, {{ $address->huyen }}, {{ $address->tinh }}</p>
                    @if ($address->diaChiMacDinh == 1)
                        <span>Mặc định</span>
                    @endif
                </div>
                <div class="button-container">
                    <a class="btn btn-warning" href="{{ route('addresses.edit', $address->maDiaChi) }}">Sửa</a>

                    <form action="{{ route('addresses.destroy', $address->maDiaChi) }}" method="POST" 
                        onsubmit="return confirm('Bạn có chắc muốn xóa địa chỉ này không?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Xóa</button>
                    </form>
                </div>
            </div>
        @endforeach
        <form id="addressForm" action="{{ route('dathang.show') }}" method="POST" style="display: none;">
            @csrf
            <input type="hidden" name="address_id" id="address_id">
        </form>

        <a class="btn btn-outline-danger" href="{{ route('addresses.create') }}">
            + Thêm Địa Chỉ Mới
        </a>
    </div>

    <script>
        function selectAddress(maDiaChi) {
        document.getElementById('address_id').value = maDiaChi;
        document.getElementById('addressForm').submit();
        }
    </script>
</x-store-layout>
