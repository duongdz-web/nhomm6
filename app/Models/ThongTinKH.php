<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThongTinKH extends Model
{
    protected $table = 'khachhang'; // đây là bảng thật trong database

    protected $primaryKey = 'maKH'; // khóa chính của bảng
   
    protected $keyType = 'string';


    protected $fillable = [
        'tenKH',
        'gioiTinh',
        'ngaySinh',
        'diaChi',
        'soDienThoai',
    ];

    public $timestamps = false; // bỏ nếu bảng không có created_at, updated_at
}
