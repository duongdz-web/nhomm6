<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiaChiGiaoHang extends Model
{
    protected $table = 'diachigiaohang';
    protected $primaryKey = 'maDiaChi';
    public $timestamps = false;

    protected $fillable = [
        'maKH', 'hoTen', 'soDienThoai', 'diaChi', 'huyen', 'phuong', 'tinh', 'diaChiMacDinh'
    ];    
    protected $casts = [
        'maKH' => 'integer',
    ];
}

