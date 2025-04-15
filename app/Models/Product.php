<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'sanpham'; // ← bảng thật
    protected $primaryKey = 'maSP';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'maSP', 'tenSP', 'moTa', 'soLuongTonKho',
        'giaNhap', 'giaBan', 'ngayNhap', 'donVi', 'maLoai', 'hinhanh'
    ];
    public function danhgias()
    {
        return $this->hasMany(DanhGia::class, 'maSP', 'maSP');
    }
}
