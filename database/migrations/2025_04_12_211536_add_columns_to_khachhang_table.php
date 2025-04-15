<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToKhachhangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('khachhang', function (Blueprint $table) {
        // Kiểm tra nếu cột chưa tồn tại trước khi thêm

        if (!Schema::hasColumn('khachhang', 'tenKH')) {
            $table->string('tenKH');
        }

        if (!Schema::hasColumn('khachhang', 'email')) {
            $table->string('email')->unique();
        }

        if (!Schema::hasColumn('khachhang', 'gioiTinh')) {
            $table->tinyInteger('gioiTinh')->nullable();
        }

        if (!Schema::hasColumn('khachhang', 'ngaySinh')) {
            $table->date('ngaySinh')->nullable();
        }

        if (!Schema::hasColumn('khachhang', 'diaChi')) {
            $table->string('diaChi')->nullable();
        }

        if (!Schema::hasColumn('khachhang', 'soDienThoai')) {
            $table->string('soDienThoai')->nullable();
        }
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('khachhang', function (Blueprint $table) {
            //
        });
    }
}