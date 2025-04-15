<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class sanpham extends Model
{
    use HasFactory;

    protected $table = 'sanpham';
    protected $primaryKey = 'maSP';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'maSP', 'tenSP', 'moTa', 'soLuongTonKho', 'giaNhap',
        'giaBan', 'ngayNhap', 'donVi', 'maLoai', 'hinhanh'
    ];
}
