<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SanPham;

class ChiTietDonDat extends Model
{
    protected $table = 'chitietdondat';
    public $timestamps = false;

    protected $fillable = [

        'maDH', 'soLuong', 'tenSP', 'ngayDat', 'TongTien', 'tinhTrang', 'maSP', 'giaBan'
    ];
    public function donhang()
    {
        return $this->belongsTo(DonDatHang::class, 'maDH', 'maDH');
    }

    public function SanPham()
    {
        return $this->belongsTo(SanPham::class, 'maSP', 'maSP');
    }

    public function dondathang()
    {
        return $this->belongsTo(DonDatHang::class, 'maDH', 'maDH');
    }
}