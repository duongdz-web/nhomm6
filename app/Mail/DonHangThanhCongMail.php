<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DonHangThanhCongMail extends Mailable
{
    use Queueable, SerializesModels;

    public $hoTen, $maDonHang, $ngayDatHang, $tongTien, $ngayGiao, $diaChi;

    public function __construct($hoTen, $maDonHang, $ngayDatHang, $tongTien, $ngayGiao, $diaChi)
    {
        $this->hoTen = $hoTen;
        $this->maDonHang = $maDonHang;
        $this->ngayDatHang = $ngayDatHang;
        $this->tongTien = $tongTien;
        $this->ngayGiao = $ngayGiao;
        $this->diaChi = $diaChi;
    }


    public function build()
    {
        return $this->subject('Đơn hàng được giao thành công!')
                    ->view('emails.donhang_thanhcong');
    }
}
