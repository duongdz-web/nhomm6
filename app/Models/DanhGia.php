<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DanhGia extends Model
{
    protected $table = 'danhgia'; // Bảng danhgia
    protected $primaryKey = 'id'; // Khóa chính của bảng danhgia

    protected $fillable = [
        'maSP', 'soSao', 'noiDung', 'maKH'
    ];

    /**
     * Quan hệ với bảng Product (mỗi đánh giá thuộc về một sản phẩm).
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'maSP', 'maSP');
    }
}
