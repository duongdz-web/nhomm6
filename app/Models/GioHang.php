<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    use HasFactory;
    
    protected $table = 'giohang';

    public function sanPham()
    {
        return $this->belongsTo(Product::class, 'maSP', 'maSP');
    }

}

