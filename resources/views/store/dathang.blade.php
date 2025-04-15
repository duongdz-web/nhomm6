<x-store-layout>
<!DOCTYPE html>
<html lang="vn">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>POCO Đặt hàng</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
        <style>
            #cartDetailsModal {
                position: fixed;
                top: 0;
                left: 0;
                width: 100vw;
                height: 100vh;
                background: rgba(0, 0, 0, 0.7);
                display: flex; /* Luôn dùng flex */
                justify-content: center;
                align-items: center;
                z-index: 9999;
                
                /* Ẩn mặc định bằng visibility và opacity */
                visibility: hidden;
                opacity: 0;
                transition: visibility 0s, opacity 0.3s ease;
            }
            #cartDetailsModal.active {
                visibility: visible;
                opacity: 1;
            }
            .cart-modal-content {
                background: white;
                padding: 20px;
                width: 50%;
                border-radius: 8px;
                max-height: 70vh;
                display: flex;
                flex-direction: column;
                overflow: hidden;
            }
            .cart-modal-content table {
                width: 100%;
                border-collapse: collapse;
            }
            .cart-modal-content table th, .cart-modal-content table td {
                padding: 10px;
                text-align: center;
                border: 1px solid #ccc;
                font-size: 20px;
            }
            .cart-modal-content .table-container {
                max-height: 60vh; /* Giới hạn chiều cao của danh sách sản phẩm */
                overflow-y: auto; /* Cho phép cuộn dọc nếu danh sách quá dài */
                margin-bottom: 20px;
            }
            #okBtn {
                background-color: #688f4e;
                color: white;
                font-size: 21px;
                padding: 10px;
                border: none;
                cursor: pointer;
                margin-top: 20px;
                display: block;
                width: 100px;
                margin-left: auto;
                margin-right: auto;
            }
            body {
                margin: 0;
                padding: 0;
                background-color: floralwhite;
                color: #333;
                min-height: 100vh;
            }
            table td{
                text-align:right; 
                height: 50px;
            }
            table th{
                text-align:left; 
                height: 50px;
            }
            .container {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
                justify-content: space-between;
     
                width: 100vw; /* hoặc 100% nếu đủ */
                max-width: 100vw;
            }
            .row {
                display: flex;
                justify-content: space-between;
                flex: 1;
            }
            @media (max-width: 768px) {
        .row {
            flex-direction: column;
        }
    }
            .form-row {
                flex: 1 1 calc(33.33% - 20px);
                /* Các form-row chiếm 1/3 chiều rộng của container */
                min-width: 300px;
                /* Giới hạn độ rộng tối thiểu */
                padding: 15px;
                font-size: 23px;
                font-family: Arial, sans-serif;
                
                /* Màu nền của khung */
                box-sizing: border-box;
                margin: 40px 40px 40px 40px;
                /* Thêm khoảng cách giữa các khung */
                /* Gradient border */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                background-origin: border-box;
                background-clip: padding-box, border-box;
                background-color: white;
            }
            select,
            input {
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                border: 1px solid #ddd;

            }
            input[type="radio"] {
                margin: 0;
                /* Đặt lại margin để tránh ảnh hưởng của kiểu mặc định */
                vertical-align: middle;
                width: 22px;
                /* Đảm bảo kích thước nút radio phù hợp */
                height: 22px;
            }
            label {
                display: inline-flex;
                /* Sử dụng inline-flex để dễ căn chỉnh */
                align-items: center;
                /* Đảm bảo căn giữa nội dung */
                gap: 15px;
                /* Thêm khoảng cách giữa radio và chữ */
                line-height: 1.2;
                /* Đặt chiều cao dòng để đồng nhất */
                font-size: 23px;
                font-family: Arial, sans-serif;
                width:100%
            }
            #discount_code, #delivery {
                width: 450px; /* Đặt chiều rộng nhỏ hơn */
                padding: 5px;
                margin: 5px 0;
                font-size: 23px;
                font-family: Arial, sans-serif;
                color: #495057;
            }
            #discount_value_display {
                font-weight: bold;
                color: green;
                margin: 0; /* Loại bỏ khoảng cách mặc định */
                white-space: nowrap; /* Tránh xuống dòng */
                text-align: right;
            }
            #discount_value_display {
                display: none;
            }
            .order-summary p {
                display: flex;
                justify-content: space-between;
            }
            .order-summary .total {
                font-weight: bold;
                font-size: 1.1em;
                color: #e53935;
            }
            #submitOrder{
                width: 100%;
                padding: 10px;
                border-radius: 5px;
                background-color: #ba382a;
                color:rgb(255, 255, 255);
                cursor: pointer;
                font-weight: bold;
            }
            #submitOrder:hover{
                background-color: #688f4e;
            }
            h2{
                color: #688f4e;
                font-weight: bold;
                font-size: 24px;
                WIDTH: 100%;
            }
            #viewCartBtn{
                padding: 0px;
                background-color: white;
                color: #ffbe24;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                font-weight: bold;
            }
            #viewCartBtn:hover {
                text-decoration: underline;
            }
            .form-row a{
                color: #ffbe24 ;
                text-decoration: none;
                font-weight: bold;
            }
            .form-row a:hover {
                text-decoration: underline;
            }
            /* Căn chỉnh các phần tử trong container */
            .left-column {
                flex: 4;
                margin-left: 30px;
            }
            .right-column {
                flex: 3;
                margin-right: 30px;
            }
            #shipping-fee-display{
                text-align:right;
            }
            input[type="radio"]:checked {
            accent-color: #910a0c; /* Thay đổi màu nút chọn khi được chọn */
        }
        </style>
    </head>

    <div class="row">
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
        @if (session('false'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Thất bại',
                    text: '{{ session("false") }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        </script>
    @endif

        <div class="left-column">
            <!-- Hình thức vận chuyển -->
            <div class="form-row">
                <h2>Hình thức vận chuyển</h2><br>
                <div class="delivery-container">
                    <table style="width: 100vh;"> 
                        <tr>
                            <td style="text-align:left; width:450px;"> 
                                <select id="delivery" class="form-control">
                                    <option>Chọn hình thức vận chuyển</option>
                                    <option>Giao hàng Nhanh</option>
                                    <option>Hỏa tốc</option>
                                </select>
                            </td>
                            <td><b><p id="shipping-fee-display"></p></b></td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Hình thức thanh toán -->
            <div class="form-row">
                <h2>Hình thức thanh toán</h2><br>
                <label>
                    <input type="radio" id="cod" name="payment" value="cod"><i class='fas fa-money-bill' style='font-size:30px'></i> Thanh toán khi nhận hàng
                </label><br><br>
                <label>
                    <input type="radio" id="payonl" name="payment" value="bank"><i class='fas fa-landmark' style='font-size:30px'></i> Thanh toán bằng chuyển khoản
                </label>
            </div>

            <!-- Mã giảm giá -->
            <div class="form-row">
                <h2>Mã giảm giá</h2><br>
                <div class="discount-container">
                    <table style="width: 100vh;">
                        <tr>
                            <td style="text-align:left; width:450px;">
                                <select id="discount_code" name="discount_code" class="form-control" {{ count($discounts) == 0 ? 'disabled' : '' }}>
                                    <option value="">
                                        {{ count($discounts) > 0 ? 'Chọn mã giảm giá' : 'Không có mã giảm giá phù hợp' }}
                                    </option>
                                    @foreach($discounts as $discount)
                                        <option value="{{ $discount->idMaGG }}">
                                            {{ $discount->moTaMaGiamGia }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="text-align:right;">
                                <p id="discount_value_display">
                                    {{ number_format($discountAmount ?? 0) }}đ
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>


        </div>

        <div class="right-column">
            <!-- Giao đến -->
            <div class="form-row">
                <table style="width: 100%;">
                    <tr>
                        <th><h2>Giao đến</h2></th>
                        <td style="text-align:right;">
                            <a href="{{ route('addresses.danhsachdiachi') }}">
                                {{ $address ? 'Thay đổi' : 'Nhập thông tin' }}
                            </a>
                        </td>
                    </tr>
                </table>

                @if ($address)
                    <p style="margin-top:10px; width:100%"><b>{{ $hoTen }}</b> | <b>{{ $soDienThoai }}</b></p><br>
                    <p>{{ $diaChi }}</p>
                @else
                    <p style="margin-top:10px;">Chưa có thông tin giao hàng.</p>
                @endif
            </div>

            <!-- Đơn hàng -->
            <div class="form-row">
                <h2>Đơn hàng</h2>
                <table style="width: 100%;">
                    <tr>
                        <th>Số lượng: {{ session('totalQuantity') }} sản phẩm</th>
                        <td><button id="viewCartBtn" style="font-size: 22px;">Xem thông tin</button></td>
                    </tr>
                    <tr>
                        <th>Tạm tính:</th>
                        <td><span>{{ number_format($subtotal, 0, ',', '.') }} đ</span></td>
                    </tr>
                    <tr>
                        <th>Phí vận chuyển:</th>
                        <td><span id="order_shippingfee">{{ $shippingFee ?? '0' }} đ</span></td>
                    </tr>
                    <tr>
                        <th>Giảm giá:</th>
                        <td><span id="order_discount_value">{{ $discountAmount ?? '0 đ' }}</span></td>
                    </tr>
                    <tr class="total">
                        <th style="color:#e53935; font-size:26px">Tổng thanh toán:</th>
                        <td style="color:#e53935; font-size:26px"><b>{{ number_format($totalPayment, 0, ',', '.') }} đ</b></td>
                    </tr>
                </table>

                <!-- Popup sản phẩm -->
                <div id="cartDetailsModal">
                    <div class="cart-modal-content">
                        <h3 style="color:#910a0c;font-weight:bold;">Các sản phẩm đã chọn:</h3><br>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Hình</th>
                                        <th>Tên sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if (!empty($selected_products) && is_array($selected_products))
                                    @foreach ($selected_products as $product)
                                        <!-- Hiển thị sản phẩm -->
                                        <tr>
                                            <td><img src="{{ asset('sanpham/' . $product['image']) }}" alt="Product Image" width="150px" height="50px"></td>
                                            <td>{{ $product['name'] }}</td>
                                            <td>{{ number_format($product['price'], 0, ',', '.') }} đ</td>
                                            <td>{{ $product['quantity'] }}</td>
                                            <td>{{ number_format($product['totalPrice'], 0, ',', '.') }} đ</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p>Không có sản phẩm nào để hiển thị.</p>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <button id="okBtn">OK</button>
                    </div>
                </div>
            </div>
        </div>
        <form id="orderForm" method="POST" action="">
            @csrf
            <input type="hidden" name="delivery_method" id="selectedDelivery">
            <input type="hidden" name="donVi" id="selectedDeliveryMethod"> <!-- Gán Giao hàng nhanh/Hỏa tốc -->
            <input type="hidden" name="payment_method" id="selectedPayment">
            <input type="hidden" id="selectedDiscount" name="selectedDiscount" value="">
            <input type="hidden" name="hoTen" value="{{ $hoTen }}">
            <input type="hidden" name="soDienThoai" value="{{ $soDienThoai }}">
            <input type="hidden" name="ngayLap" value="{{ \Carbon\Carbon::now()->toDateString() }}">
            <input type="hidden" name="maKH" value="{{ Auth::id() }}">
            <input type="hidden" name="tinhTrang" value="Chờ xử lý">
            <input type="hidden" name="diaChi" value="{{ $diaChi }}">
            <input type="hidden" name="totalPayment" value="{{ $totalPayment }}">
            <input type="hidden" name="shipping_fee" id="hiddenShippingFee" value="">


            <button type="submit" id="submitOrder" style="font-size: 25px;width:100vw;">Đặt hàng</button>
        </form>
    </div>
        
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const discountSelect = document.getElementById('discount_code');
            const discountDisplay = document.getElementById('discount_value_display');
            const orderDiscountDisplay = document.getElementById('order_discount_value');
            const totalPaymentDisplay = document.querySelector('.total td b');

            const subtotal = {{ $subtotal }};
            const shippingFee = {{ $shippingFee ?? 0 }};
            const discounts = @json($discounts);

            const viewCartBtn = document.getElementById('viewCartBtn');
            const cartModal = document.getElementById('cartDetailsModal');
            const okBtn = document.getElementById('okBtn');

            viewCartBtn.addEventListener('click', function () {
                cartModal.classList.add('active');
            });

            okBtn.addEventListener('click', function () {
                cartModal.classList.remove('active');
            });

            // Đóng khi click ra ngoài nội dung
            cartModal.addEventListener('click', function (event) {
                if (event.target === cartModal) {
                    cartModal.classList.remove('active');
                }
            });

            // Ẩn vùng hiển thị giảm giá ban đầu
            discountDisplay.style.display = 'none';
            orderDiscountDisplay.innerText = formatCurrency(0, true);

            function formatCurrency(value, isNegative = false) {
                const formatted = new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                return isNegative ? '– ' + formatted : formatted;
            }


            discountSelect.addEventListener('change', function () {
                const selectedId = this.value;
                const discount = discounts.find(item => item.idMaGG == selectedId);

                let discountAmount = 0;

                if (discount) {
                    discountAmount = discount.soTienGiam;
                    // Hiển thị vùng hiển thị số tiền giảm
                    discountDisplay.style.display = 'inline';
                } else {
                    // Nếu không chọn gì, ẩn vùng hiển thị
                    discountDisplay.style.display = 'none';
                }

                // Cập nhật số tiền giảm
                discountDisplay.innerText = formatCurrency(discountAmount, true);
                orderDiscountDisplay.innerText = formatCurrency(discountAmount, true);

                // Cập nhật tổng thanh toán
                const shippingFeeRaw = document.getElementById('order_shippingfee').innerText.replace(/\D/g, '');
                const currentShippingFee = parseInt(shippingFeeRaw) || 0;
                const total = subtotal + currentShippingFee - discountAmount;

                totalPaymentDisplay.innerText = formatCurrency(total);

                // Gán vào hidden input để submit
                document.getElementById('selectedDiscount').value = selectedId;
            });
        });


        const selectedProvince = @json($tinh);
        const locations = @json(json_decode(file_get_contents(public_path('locations.json')), true));

        document.getElementById("delivery").addEventListener("change", updateShippingFee);

        function updateShippingFee() {
            const deliveryElement = document.getElementById("delivery");
            const deliveryMethod = deliveryElement.value;
            const hcmLat = locations["TP. Hồ Chí Minh"].lat;
            const hcmLng = locations["TP. Hồ Chí Minh"].lng;

            if (!selectedProvince || !locations[selectedProvince]) {
                alert("Vui lòng chọn địa chỉ giao hàng trước.");
                document.getElementById("shipping-fee-display").innerText = "0 đ";
                document.getElementById("order_shippingfee").innerText = "0 đ";
                return;
            }

            if (deliveryMethod === "Chọn hình thức vận chuyển") {
                deliveryElement.value = "Giao hàng Nhanh";
                updateShippingFee();
                return;
            }

            const provinceLat = locations[selectedProvince].lat;
            const provinceLng = locations[selectedProvince].lng;

            function calculateDistance(lat1, lng1, lat2, lng2) {
                const R = 6371;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLng = (lng2 - lng1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLng / 2) * Math.sin(dLng / 2);
                return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            }

            const distance = calculateDistance(hcmLat, hcmLng, provinceLat, provinceLng);
            let shippingFee = 0;

            if (deliveryMethod === "Hỏa tốc") {
                if (selectedProvince !== "TP. Hồ Chí Minh") {
                    alert("Phương thức giao hàng Hỏa tốc chỉ áp dụng tại TP. Hồ Chí Minh. Hệ thống sẽ chuyển sang Giao hàng Nhanh.");
                    deliveryElement.value = "Giao hàng Nhanh";
                }
            }

            const updatedDeliveryMethod = deliveryElement.value;

            if (updatedDeliveryMethod === "Giao hàng Nhanh") {
                if (distance <= 50) {
                    shippingFee = 15000;
                } else if (distance <= 500) {
                    shippingFee = 25000;
                } else {
                    shippingFee = 40000;
                }
            } else if (updatedDeliveryMethod === "Hỏa tốc") {
                shippingFee = 40000;
            }

            document.getElementById("shipping-fee-display").innerText = new Intl.NumberFormat('vi-VN').format(shippingFee) + " đ";
            document.getElementById("order_shippingfee").innerText = new Intl.NumberFormat('vi-VN').format(shippingFee) + " đ";

            const subtotal = {{ $subtotal }};
            const discountRaw = document.getElementById("order_discount_value").innerText.replace(/\D/g, '');
            const discountAmount = parseInt(discountRaw) || 0;
            const totalPayment = subtotal + shippingFee - discountAmount;

            document.querySelector(".total td b").innerText = new Intl.NumberFormat('vi-VN').format(totalPayment) + " đ";
            document.getElementsByName("totalPayment")[0].value = totalPayment;

            // Gán phí ship để gửi qua form nếu cần
            let hiddenInput = document.getElementById("hiddenShippingFee");
            if (!hiddenInput) {
                hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "shipping_fee";
                hiddenInput.id = "hiddenShippingFee";
                document.querySelector("form").appendChild(hiddenInput);
            }
            hiddenInput.value = shippingFee;
            
        }

        function getCurrentShippingFee() {
            const raw = document.getElementById('order_shippingfee').innerText.replace(/\D/g, '');
            return parseInt(raw) || 0;
        }

        function getCurrentDiscountAmount() {
            const raw = document.getElementById("order_discount_value").innerText.replace(/\D/g, '');
            return parseInt(raw) || 0;
        }

        function updateTotalPayment() {
            const currentShippingFee = getCurrentShippingFee();
            const discountAmount = getCurrentDiscountAmount();
            const total = subtotal + currentShippingFee - discountAmount;
            totalPaymentDisplay.innerText = formatCurrency(total);
            document.getElementsByName("totalPayment")[0].value = total;
        }

        document.getElementById('submitOrder').addEventListener('click', function (e) {
            e.preventDefault();

            const selectedDelivery = document.getElementById('delivery').value;
            const selectedPayment = document.querySelector('input[name="payment"]:checked')?.value;
            const selectedDiscount = document.getElementById('discount_code').value;

            if (selectedDelivery === 'Chọn hình thức vận chuyển') {
                alert("Vui lòng chọn hình thức vận chuyển!");
                return;
            }

            if (!selectedPayment) {
                alert("Vui lòng chọn hình thức thanh toán!");
                return;
            }

            document.getElementById('selectedDeliveryMethod').value = selectedDelivery;
            document.getElementById('selectedDelivery').value = selectedDelivery;
            document.getElementById('selectedPayment').value = selectedPayment;
            document.getElementById('selectedDiscount').value = selectedDiscount;

            const form = document.getElementById('orderForm');

            if (selectedPayment === 'cod') {
                form.action = '{{ route("cod.order") }}';
            } else if (selectedPayment === 'bank') {
                form.action = '{{ route("vnpay.create") }}';
            }

            form.submit();
        });

    </script>
</x-store-layout>