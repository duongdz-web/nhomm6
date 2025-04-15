<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DonHangExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        $data = DB::table('dondathang')
            ->join('khachhang', 'dondathang.maKH', '=', 'khachhang.maKH')
            ->join('chitietdondat', 'dondathang.maDH', '=', 'chitietdondat.maDH')
            ->join('sanpham', 'chitietdondat.maSP', '=', 'sanpham.maSP')
            ->select(
                'dondathang.maDH',
                'khachhang.tenKH',
                'khachhang.diaChi',
                'dondathang.ngayLap',
                'sanpham.tenSP',
                'chitietdondat.soLuong',
                DB::raw('chitietdondat.soLuong * sanpham.giaBan as tongTien'),
                'dondathang.tinhTrang'
            )
            ->orderBy('dondathang.ngayLap', 'desc')
            ->get();

        return new Collection($data);
    }

    public function headings(): array
    {
        return [
            'Mã đơn',
            'Khách hàng',
            'Địa chỉ',
            'Ngày đặt',
            'Sản phẩm',
            'Số lượng',
            'Tổng tiền',
            'Tình trạng',
        ];
    }
}
