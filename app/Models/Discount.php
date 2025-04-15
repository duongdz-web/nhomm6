<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = 'magiamgia'; 

    protected $primaryKey = 'idMaGG'; 

    public $timestamps = false; 

    protected $fillable = [
        'maGG',
        'soTienGiam',
        'dieuKienDonHangToiThieu',
        'moTaMaGiamGia',
    ];
    public function users()
{
    return $this->belongsToMany(User::class, 'discounts_kh', 'idMaGG', 'maKH');
}

}

