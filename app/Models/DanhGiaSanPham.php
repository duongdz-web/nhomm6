<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhGiaSanPham extends Model
{
    use HasFactory;

    protected $table = 'danhgia';
    protected $primaryKey = 'id'; // sửa theo DB của bạn nếu không phải là 'id'
    public $timestamps = false;

    protected $fillable = [
        'maSP',
        'maDH',
        'soSao',
        'moTa',
    ];

    // Quan hệ với bảng sản phẩm
    public function sanpham()
    {
        return $this->belongsTo(SanPham::class, 'maSP', 'maSP');
    }

    // Quan hệ với bảng đơn hàng
    public function dondathang()
    {
        return $this->belongsTo(DonDatHang::class, 'maDH', 'maDH');
    }
}