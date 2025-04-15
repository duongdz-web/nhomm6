<x-store-layout>
    <style>
        .form-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white; 
            width: 100%;
            max-width: 100%;
        }
        .form {
            width: 500px;
            background: white;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 20px auto;
        }


        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #910a0c;
            font-size: 24px;
            font-weight: bold;
        }

        .form-label strong {
            color: #688f4e;
            font-size: 17px;
        }

        input[type="text"].form-control {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }

        input[type="checkbox"]#diaChiMacDinh {
            width: 15px;
            accent-color: #910a0c;
        }

        .form-check-label {
            margin-left: 8px;
        }

        .btn-warning {
            background: #ffbe24;
            color: black;
            border: 3px solid #ffbe24;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 150px;
            font-size: 16px;
        }

        .btn-warning:hover {
            background-color: #688f4e;
            color: white;
        }

        .btn-danger {
            background: #910a0c;
            color: white;
            border: 3px solid #910a0c;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            cursor: pointer;
            width: 150px;
            font-size: 16px;
        }

        .btn-danger:hover {
            background-color: white;
            color: #910a0c;
        }

        .btn-outline-success {
            float: right;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            color: #688f4e;
            transition: color 0.3s ease;
            margin: -50px -05px 10px 0; 
        }

        .btn-outline-success:hover {
            color: #910a0c;
            background: none;
        }

        .text-end button {
            width: 150px;
        }
        .button-container {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
        }
        #province-select{
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            font-size: 16px;
            width: 100%;
        }

    </style>
    <div class="form-wrapper">
        <div class="form">
            <h2 >THÔNG TIN GIAO HÀNG</h2>
            <a class="btn btn-outline-success" href="{{ route('addresses.danhsachdiachi') }}">
                <i class="fa-solid fa-circle-xmark"></i> 
            </a>

            <form id="updateForm" method="POST" action="{{ $isNew ? route('addresses.store') : route('addresses.update', $address->maDiaChi) }}">
                @csrf
                @if (!$isNew)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label class="form-label"><strong>Họ và tên</strong></label>
                    <input type="text" class="form-control" name="hoTen" value="{{ old('hoTen', $address->hoTen) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Số điện thoại</strong></label>
                    <input type="text" class="form-control" name="soDienThoai" value="{{ old('soDienThoai', $address->soDienThoai) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Địa chỉ</strong></label>
                    <input type="text" class="form-control" name="diaChi" value="{{ old('diaChi', $address->diaChi) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Huyện</strong></label>
                    <input type="text" class="form-control" name="huyen" value="{{ old('huyen', $address->huyen) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Phường/Xã</strong></label>
                    <input type="text" class="form-control" name="phuong" value="{{ old('phuong', $address->phuong) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Tỉnh</strong></label>
                    <select class="form-control" name="tinh" id="province-select" required>
                        <option value="">-- Chọn tỉnh --</option>
                        {{-- Dữ liệu sẽ được thêm vào bằng JS --}}
                    </select>
                </div>


                <div class="form-check mb-4">
                <input type="hidden" name="diaChiMacDinh" value="0">

<input type="checkbox" id="diaChiMacDinh" name="diaChiMacDinh" value="1"
    {{ old('diaChiMacDinh', $address->diaChiMacDinh ?? false) ? 'checked' : '' }}>
<label class="form-check-label">Đặt làm địa chỉ mặc định</label>
                </div>

                @if (!$isNew)
                    <div class="button-container">
                        <form method="POST" action="{{ $isNew ? route('addresses.store') : route('addresses.update', $address->maDiaChi) }}">
                            @csrf
                            @if (!$isNew)
                                @method('PUT')
                            @endif
                            <button type="submit" class="btn btn-warning">Xác nhận</button>
                        </form>

                        <form method="POST" action="{{ route('addresses.destroy', $address->maDiaChi) }}" onsubmit="return confirm('Bạn có chắc chắn muốn xóa địa chỉ này?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </div>
                @else
                <div class="flex justify-center">
                    <button type="submit" class="btn btn-warning">Xác nhận</button>
                </div>
                @endif
            </form>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            fetch("/locations.json")
                .then(response => response.json())
                .then(data => {
                    const select = document.getElementById("province-select");
                    const selectedValue = "{{ old('tinh', $address->tinh ?? '') }}";

                    Object.keys(data).sort().forEach(province => {
                        const option = document.createElement("option");
                        option.value = province;
                        option.text = province;
                        if (province === selectedValue) {
                            option.selected = true;
                        }
                        select.appendChild(option);
                    });
                })
                .catch(error => console.error("Lỗi khi load danh sách tỉnh:", error));
        });
    </script>

</x-store-layout>
