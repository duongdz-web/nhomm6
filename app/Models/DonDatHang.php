<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\ChiTietDonDat;

class DonDatHang extends Model
{
    use HasFactory;
    protected $table = 'dondathang';
    public $timestamps = false;
    protected $primaryKey = 'maDH'; // 👈 Thêm dòng này
    protected $dates = ['ngayLap'];
    

    
    protected $fillable = [
        'maDH', 'maKH', 'tenKH', 'soDienThoai','ngayLap', 'giaBan', 'tinhTrang', 'diaChi','tongTienThanhToan'
    ];
    public function chitiet()
{
    return $this->hasMany(ChiTietDonDat::class, 'maDH', 'maDH');
}
  public function chitietdondat()
    {
        return $this->hasMany(ChiTietDonDat::class, 'maDH', 'maDH');
    }
  public function donhangs()
  {
      return $this->hasMany(DonDatHang::class, 'maKH', 'maKH');
  }
  public function khachhang()
    {
        return $this->belongsTo(User::class, 'maKH', 'id');
    }

}
