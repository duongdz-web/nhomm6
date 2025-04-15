<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\MaGiamGiaController;

use App\Http\Controllers\StoreController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NhanvienController ;
use App\Http\Controllers\DonDatHangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DatHangController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\VnpayController;
use App\Http\Controllers\CODController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ThongTinKHController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


Route::get('/', [StoreController::class, 'index'])->name('home');
Route::get('/chitiet/{maSP}', [ProductController::class, 'show'])->name('products.chitiet');
Route::get('/category/{maLoai}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// nyan
Route::get('/accountpanel', [AccountController::class, 'accountpanel'])
    ->middleware('auth')
    ->name('account');

// Lan
Route::match(['get', 'post'], '/dathang', [DatHangController::class, 'show'])->name('dathang.show');

//nyan
//quan ly san pham 
Route::get('/nhanvien/sanpham', [NhanvienController::class, 'sanpham'])->name('nhanvien.sanpham');
Route::get('/nhanvien/sanpham/{id}/edit', [NhanvienController::class, 'edit'])->name('nhanvien.sanpham.edit');
Route::get('/nhanvien/sanpham/edit/{maSP}', [NhanvienController::class, 'edit'])->name('nhanvien.sanpham.edit');
Route::delete('/nhanvien/sanpham/{id}', [NhanvienController::class, 'destroy'])->name('nhanvien.sanpham.delete');
Route::put('/nhanvien/sanpham/{id}', [NhanvienController::class, 'update'])->name('nhanvien.sanpham.update');
Route::put('/nhanvien/sanpham/update/{maSP}', [NhanvienController::class, 'update'])->name('nhanvien.sanpham.update');
Route::get('/nhanvien/sanpham/create', [NhanvienController::class, 'create'])->name('nhanvien.sanpham.create');
Route::post('/nhanvien/sanpham/store', [NhanvienController::class, 'store'])->name('nhanvien.sanpham.store');
//nyan
//đăng nhập, đăng ký

Route::post('/cod-order', [CODController::class, 'processCOD'])->name('cod.order');
Route::post('/vnpay/create', [VnpayController::class, 'createPayment'])->name('vnpay.create');
Route::get('/vnpay/return', [VnpayController::class, 'paymentReturn'])->name('vnpay.return');


// Dương
Route::post('/capnhapsoluong', [CartController::class, 'capnhapsoluong'])
    ->middleware('auth')->name('cart.updateQuantity');


Route::post('/xoasanpham', [CartController::class, 'xoaSanPham'])->name('xoasanpham');
Route::post('/checkbox', [CartController::class, 'checkbox'])->name('checkbox');


Route::middleware(['auth'])->group(function () {
    Route::get('/don-dat-hang', [DonDatHangController::class, 'index'])->name('dondathang.index');
    Route::get('/don-dat-hang/{maDH}', [DonDatHangController::class, 'chitiet'])->name('dondathang.chitiet');
    Route::put('/don-dat-hang/{maDH}/huy', [DonDatHangController::class, 'huy'])->name('dondathang.huy');
});
Route::get('/dondathang', [DonDatHangController::class, 'index'])->name('dondathang.index');



// Lan

Route::match(['get', 'post'], '/dathang', [DatHangController::class, 'show'])->name('dathang.show');

Route::middleware(['auth'])->group(function () {
    Route::get('/addresses', [AddressController::class, 'danhsachdiachi'])->name('addresses.danhsachdiachi');
    Route::post('/addresses/update-default', [AddressController::class, 'updateDefault'])->name('addresses.update-default');
    Route::get('/addresses/create', [AddressController::class, 'create'])->name('addresses.create'); // Thêm mới
    Route::get('/addresses/{maDiaChi}/edit', [AddressController::class, 'edit'])->name('addresses.edit'); // Sửa địa chỉ
    Route::post('/addresses', [AddressController::class, 'store'])->name('addresses.store');
    Route::get('/addresses/{id}/edit', [AddressController::class, 'edit'])->name('addresses.edit');
    Route::put('/addresses/{id}', [AddressController::class, 'update'])->name('addresses.update');
    Route::delete('/addresses/{id}', [AddressController::class, 'destroy'])->name('addresses.destroy');
});

Route::post('/cod-order', [CODController::class, 'processCOD'])->name('cod.order');
Route::POST('/vnpay/create', [VnpayController::class, 'createPayment'])->name('vnpay.create');
Route::get('/vnpay/return', [VnpayController::class, 'paymentReturn'])->name('vnpay.return');


// Dương
Route::post('/xoasanpham','App\Http\Controllers\CartController@xoaSanPham')
->name("xoasanpham");

Route::post('/checkbox','App\Http\Controllers\CartController@checkbox')
->name("checkbox");

Route::get('/giohang', [CartController::class, 'giohang'])
    ->middleware('auth')->name('giohang.index');

Route::post('/giohang', [CartController::class, 'store'])
    ->middleware('auth')->name('giohang.store');
    

    
Route::get('/nhanvien', [NhanvienController::class, 'sanpham']);

Route::get('/nhanvien','App\Http\Controllers\NhanvienController@sanpham');

Route::get('/chitiet/{maSP}', [ProductController::class, 'show'])->name('products.chitiet');
Route::get('/category/{maLoai}', [CategoryController::class, 'show'])->name('category.show');
Route::get('/search', [ProductController::class, 'search'])->name('products.search');

// nyan
Route::get('/accountpanel', [AccountController::class, 'accountpanel'])
    ->middleware('auth')
    ->name('account');

Route::post('/cod-order', [CODController::class, 'processCOD'])->name('cod.order');
Route::post('/vnpay/create', [VnpayController::class, 'createPayment'])->name('vnpay.create');
Route::get('/vnpay/return', [VnpayController::class, 'paymentReturn'])->name('vnpay.return');

// Dương
Route::post('/capnhapsoluong', [CartController::class, 'capnhapsoluong'])
    ->middleware('auth')->name('cart.updateQuantity');

Route::post('/xoasanpham', [CartController::class, 'xoaSanPham'])->name('xoasanpham');
Route::post('/checkbox', [CartController::class, 'checkbox'])->name('checkbox');


Route::middleware(['auth'])->group(function () {
    Route::get('/don-dat-hang', [DonDatHangController::class, 'index'])->name('dondathang.index');
    Route::get('/don-dat-hang/{maDH}', [DonDatHangController::class, 'chitiet'])->name('dondathang.chitiet');
    Route::put('/don-dat-hang/{maDH}/huy', [DonDatHangController::class, 'huy'])->name('dondathang.huy');
});



Route::get('/khachhang/sua', [DonDatHangController::class, 'chinhsuathongtin'])->name('khachhang.sua');
Route::post('/khachhang/sua', [DonDatHangController::class, 'capnhatthongtin'])->name('khachhang.capnhat');

Route::get('dondathang/{maDH}/danhgia/{maSP}', [DonDatHangController::class, 'hienThiFormDanhGia'])->name('dondathang.danhgia');
Route::post('dondathang/{maDH}/danhgia/{maSP}', [DonDatHangController::class, 'luuDanhGia'])->name('dondathang.danhgia.luu');



Route::get('/giohang', [CartController::class, 'giohang'])
    ->middleware('auth')->name('giohang.index');

Route::post('/giohang', [CartController::class, 'store'])
    ->middleware('auth')->name('giohang.store');
// quynciii
Route::get('store', [StoreController::class, 'index']);
Route::get('/khachhang', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/customers/export', [CustomerController::class, 'export'])->name('customers.export');
Route::get('/don-hang', [DonHangController::class, 'index'])->name('donhang.index');
Route::get('/don-hang/export', [DonHangController::class, 'export'])->name('donhang.export');

Route::put('/don-hang/update-trangthai/{maDH}', [DonHangController::class, 'updateTrangThai'])->name('donhang.updateTrangThai');


    
Route::get('/doanhthu', [NhanvienController::class, 'doanhthu'])->name('nhanvien.doanhthu');
Route::get('/nhanvien', [NhanvienController::class, 'sanpham']);


Route::get('/testemail',[CartController::class,'testemail']);
