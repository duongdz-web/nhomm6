<?php

namespace App\Observers;

use App\Models\DonDatHang;
use App\Models\User;
use App\Mail\DonHangThanhCongMail;
use Illuminate\Support\Facades\Mail;

class DonDatHangObserver
{
    /**
     * Handle the DonDatHang "created" event.
     *
     * @param  \App\Models\DonDatHang  $donDatHang
     * @return void
     */
    public function created(DonDatHang $donDatHang)
    {
        //
    }

    /**
     * Handle the DonDatHang "updated" event.
     *
     * @param  \App\Models\DonDatHang  $donDatHang
     * @return void
     */
    public function updated(DonDatHang $donHang)
{
    if ($donHang->isDirty('tinhTrang') && $donHang->tinhTrang === 'Đã giao') {
        $khachHang = User::find($donHang->maKH);
        if ($khachHang && $khachHang->email) {
            Mail::to($khachHang->email)->send(new DonHangThanhCongMail(
                $khachHang->name,
                $donHang->maDH,
                $donHang->ngayLap->format('d/m/Y'),
                $donHang->tongTienThanhToan ?? 0,
                now()->format('d/m/Y'),
                $donHang->diaChi
            ));
        }
    }
}

    /**
     * Handle the DonDatHang "deleted" event.
     *
     * @param  \App\Models\DonDatHang  $donDatHang
     * @return void
     */
    public function deleted(DonDatHang $donDatHang)
    {
        //
    }

    /**
     * Handle the DonDatHang "restored" event.
     *
     * @param  \App\Models\DonDatHang  $donDatHang
     * @return void
     */
    public function restored(DonDatHang $donDatHang)
    {
        //
    }

    /**
     * Handle the DonDatHang "force deleted" event.
     *
     * @param  \App\Models\DonDatHang  $donDatHang
     * @return void
     */
    public function forceDeleted(DonDatHang $donDatHang)
    {
        //
    }
}
