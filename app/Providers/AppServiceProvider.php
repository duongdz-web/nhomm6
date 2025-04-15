<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

use App\Models\DonDatHang;
use App\Observers\DonDatHangObserver;
use Illuminate\Support\Facades\View;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::share('categories', [
            ['icon' => 'fa-utensils', 'label' => 'Đồ ăn', 'code' => 'LS0001'],
            ['icon' => 'fa-coffee', 'label' => 'Đồ uống', 'code' => 'LS0002'],
            ['icon' => 'fa-couch', 'label' => 'Tiện ích gia đình', 'code' => 'LS0003'],
            ['icon' => 'fa-box', 'label' => 'Hàng gia dụng', 'code' => 'LS0004'],
            ['icon' => 'fa-pencil-alt', 'label' => 'Văn phòng phẩm', 'code' => 'LS0005'],
            ['icon' => 'fa-gamepad', 'label' => 'Đồ chơi', 'code' => 'LS0006'],
            ['icon' => 'fa-magic', 'label' => 'Sản phẩm làm đẹp', 'code' => 'LS0007'],
            ['icon' => 'fa-boxes', 'label' => 'Thực phẩm đóng hộp', 'code' => 'LS0008'],
        ]);
        //
        Schema::defaultStringLength(191);
        DonDatHang::observe(DonDatHangObserver::class);

    }

}
