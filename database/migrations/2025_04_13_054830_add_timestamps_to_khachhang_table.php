<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTimestampsToKhachhangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('khachhang', function (Blueprint $table) {
        $table->timestamps(); // thêm 2 cột created_at, updated_at
    });
}

public function down()
{
    Schema::table('khachhang', function (Blueprint $table) {
        $table->dropTimestamps();
    });
}

}
