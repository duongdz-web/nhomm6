<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'khachhang'; // ✅ Đặt tên bảng đúng với database

    // Nếu bảng không có cột timestamps (created_at, updated_at), thêm dòng này:
    public $timestamps = false;
}
