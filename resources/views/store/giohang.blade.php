<x-store-layout>
    <x-slot name='title'>
        Giỏ hàng
    </x-slot>
    <div class="cart-container container-fluid table-responsive">
        <div class='row'>
            <div class='col-8 pr-0 border'>
                <table>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all" style="width: 100%; height: 100%;"> Chọn tất cả
                            </th>
                            <th>Sản phẩm</th>
                            <th>Mô tả</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr class="product-item">
                                <!-- Checkbox -->
                                <td>
                                    <input type="checkbox" class="product-checkbox" name="selected_products[]"

                                        data-id="{{ $item->maSP }}" data-price="{{ $item->giaBan ?? $item->giaBanGoc }}"
                                        data-soluong="{{ $item->soLuong }}">
                                </td>
                                <!-- Hình ảnh -->
                                <td>
                                    <a href="{{ route('products.chitiet', ['maSP' => $item->maSP]) }}">
                                        <img src="{{ asset('sanpham/' . $item->hinhanh) }}" alt="Product Image"
                                            class="product-img" width="100px" height="100px">
                                    </a>
                                </td>
                                <!-- Tên sản phẩm -->
                                <td>
                                    <a href="{{ route('products.chitiet', ['maSP' => $item->maSP]) }}">
                                        {{ $item->tenSP }}
                                    </a>
                                </td>
                                <!-- Giá -->
                                <td class="price">
                                    @if (!is_null($item->giaBan))
                                        <span>
                                            {{ number_format($item->giaBan, 0, ',', '.') }} đ
                                        </span>
                                        <span class="ml-2 line-through italic text-gray-500">
                                            {{ number_format($item->giaBanGoc, 0, ',', '.') }} đ
                                        </span>
                                    @else
                                        <span>
                                            {{ number_format($item->giaBanGoc, 0, ',', '.') }} đ
                                        </span>
                                    @endif
                                </td>

                                <!-- Số lượng -->
                                <td>
                                    <form method="POST" action="" class="update-quantity">
                                        @csrf
                                        <input type="hidden" name="maSP" value="{{ $item->maSP }}">
                                        <button type="button" class="decrease buttonCus" data-action="decrease">-</button>
                                        <span class="quantity">{{ $item->soLuong }}</span>
                                        <button type="button" class="increase buttonCus" data-action="increase">+</button>
                                    </form>
                                </td>

                                <!-- Thành tiền -->
                                <td class="total" style="font-size: 17pt">
                                    {{ number_format($item->thanhTien, 0, ',', '.') }} đ
                                </td>

                                <!-- Xóa -->
                                <td class="actions">
                                    <form method="POST" action="" class="delete-product-form">
                                        @csrf
                                        <input type="hidden" name="maSP" value="{{ $item->maSP }}">
                                        <button class="delete-button buttonDel" type="submit">
                                            <span class="buttonDel__text" style="font-size: 14pt;">Xóa</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            <!-- Tổng cộng -->
            <div class='col-4 pl-0'>

                <div id="selected_products-list" style="margin-top: 10px;">
                    <strong>Sản phẩm đã chọn: <span id="selected-count">0 </span></strong>
                    <ul id="product-list" style="padding-left: 16px;"></ul>
                </div>

                <div class="total container-fluid sticky-bottom">
                    Tổng cộng: <span id="total">0</span> đ <br>
                    <button id="proceedToPayment" class="btn btn-primary">Thanh toán</button>

                    <!-- Form thanh toán ẩn -->
                    <form id="paymentForm" method="POST" action="{{ route('dathang.show') }}" style="display: none;">
                        @csrf
                        <input type="hidden" id="hiddenTotal" name="total">
                        <input type="hidden" id="hiddenTotalQuantity" name="totalQuantity">
                        <input type="hidden" id="hiddenProducts" name="products">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>

        //thay đổi số lượng
        $(document).ready(function () {
            $('.update-quantity .buttonCus').click(function () {
                const button = $(this);
                const action = button.data('action'); // 'increase' hoặc 'decrease'
                const form = button.closest('.update-quantity');
                const maSP = form.find('input[name="maSP"]').val();
                const quantityElement = form.find('.quantity');

                $.ajax({
                    url: "{{ route('cart.updateQuantity') }}",
                    type: 'POST',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        maSP: maSP,
                        action: action
                    },
                    success: function (data) {
                        if (data.success) {
                            quantityElement.text(data.newQuantity);
                            form.closest('tr').find('.total').text(data.newTotal.toLocaleString('vi-VN') + ' đ');

                            // Cập nhật lại data-soluong
                            const checkbox = form.closest('tr').find('.product-checkbox');
                            checkbox.data('soluong', data.newQuantity);

                            updateCartTotal();
                        } else {
                            alert(data.message);
                        }
                    },

                    error: function (xhr) {
                        alert('Lỗi khi cập nhật số lượng!');
                        console.error(xhr.responseText);
                    }
                });
            });
        });

        //xóa sản phẩm
        $(".delete-product-form").each(function () {
            const form = $(this);
            const deleteBtn = form.find('.delete-button');

            deleteBtn.on("click", function (e) {
                e.preventDefault(); // Ngăn submit form mặc định

                const maSP = form.find('input[name="maSP"]').val(); // Lấy động lúc bấm nút

                if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                    $.ajax({
                        type: "POST",
                        url: "{{ route('xoasanpham') }}",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            maSP: maSP
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                form.closest("tr").remove(); // Xóa dòng sản phẩm
                                updateCartTotal(); // Nếu có hàm cập nhật tổng tiền
                                alert(data.message);
                            } else {
                                alert(data.message);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.error("Lỗi khi xóa sản phẩm:", error);
                        }
                    });
                }
            });
        });

        //xử lý check box
        $(document).ready(function () {
            const $selectAll = $("#select-all");
            const $productCheckboxes = $(".product-checkbox");

            // Hàm kiểm tra và cập nhật trạng thái "Chọn tất cả"
            function toggleSelectAllCheckbox() {
                const allChecked = $productCheckboxes.length === $productCheckboxes.filter(":checked").length;
                $selectAll.prop("checked", allChecked);
            }

            // Sự kiện tick checkbox sản phẩm
            $productCheckboxes.on("change", function () {
                toggleSelectAllCheckbox(); // Cập nhật trạng thái "Chọn tất cả"
                // (Tuỳ chọn) Gửi AJAX cập nhật trạng thái từng sản phẩm
                const maSP = $(this).data("id");
                const checked = $(this).is(":checked") ? 1 : 0;

                $.ajax({
                    url: "{{ route('checkbox') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        maSP: maSP,
                        checked: checked
                    },
                    success: function (response) {
                        console.log("Đã cập nhật maSP:", maSP);
                        updateCartTotal();         // Cập nhật tổng tiền
                    },
                    error: function (xhr) {
                        console.error("Lỗi cập nhật:", xhr.responseText);
                    }
                });
            });

            // Sự kiện tick "Chọn tất cả"
            $selectAll.on("change", function () {
                const isChecked = $(this).is(":checked");

                $productCheckboxes.each(function () {
                    $(this).prop("checked", isChecked);

                    // (Tuỳ chọn) Gửi AJAX cho từng checkbox
                    const maSP = $(this).data("id");

                    $.ajax({
                        url: "{{ route('checkbox') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            maSP: maSP,
                            checked: isChecked ? 1 : 0
                        },
                        success: function (response) {
                            console.log("Cập nhật maSP:", maSP);
                        },
                        error: function (xhr) {
                            console.error("Lỗi:", xhr.responseText);
                        }
                    });
                });

                updateCartTotal(); // Cập nhật tổng tiền
            });

            // Khi trang load lần đầu → cập nhật trạng thái "Chọn tất cả"
            toggleSelectAllCheckbox();
        });

        // Hàm tính tổng tiền dựa vào checkbox đã chọn
        function updateCartTotal() {
            let total = 0;
            let productListHTML = '';
            let selectedCount = 0;

            $('.product-checkbox:checked').each(function () {
                const checkbox = $(this);
                const productItem = checkbox.closest('.product-item');
                const quantityElement = productItem.find('.quantity');
                const price = parseFloat(checkbox.data('price'));
                const tenSP = productItem.find('td:nth-child(3) a').text().trim(); // Lấy tên sản phẩm

                if (quantityElement.length) {
                    const quantity = parseInt(quantityElement.text());
                    const thanhTien = quantity * price;
                    total += thanhTien;
                    selectedCount++;
                    productListHTML += `<li>${tenSP} - ${quantity} x ${price.toLocaleString('vi-VN')} đ</li>`;
                }
            });

            $('#total').text(total.toLocaleString('vi-VN') + " đ");
            $('#product-list').html(productListHTML);
            $('#selected-count').text(selectedCount);
        }
        document.getElementById('proceedToPayment').addEventListener('click', function () {
            let selected = document.querySelectorAll('.product-checkbox:checked');
            let products = [];
            let total = 0;
            let totalQuantity = 0;

            selected.forEach(function (checkbox) {
                let maSP = checkbox.getAttribute('data-id');
                let price = parseFloat(checkbox.getAttribute('data-price'));
                let quantity = parseInt(checkbox.closest('tr').querySelector('.quantity').textContent);


                products.push({
                    maSP: maSP,
                    soLuong: quantity
                });

                total += price * quantity;
                totalQuantity += quantity;
            });

            document.getElementById('hiddenTotal').value = total;
            document.getElementById('hiddenTotalQuantity').value = totalQuantity;
            document.getElementById('hiddenProducts').value = JSON.stringify(products);
            document.getElementById('paymentForm').submit();
        });



        const tenSP = productItem.find('td:nth-child(3) a').text().trim(); // Lấy tên sản phẩm

        if (quantityElement.length) {
            const quantity = parseInt(quantityElement.text());
            const thanhTien = quantity * price;
            total += thanhTien;
            selectedCount++;
            // Thêm dòng vào danh sách hiển thị
            productListHTML += `<li>${tenSP} - ${quantity} x ${price.toLocaleString('vi-VN')} đ</li>`;
        }

    </script>
</x-store-layout>