<?php

namespace App\Exports;

use App\Models\sanpham;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SanPhamExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Sanpham::select(
            'maSP', 'tenSP', 'giaNhap', 'giaBan', 
            'maLoai', 'soLuongTonKho', 'ngayNhap', 'donVi', 'hinhanh'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Mã sản phẩm',
            'Tên sản phẩm',
            'Giá nhập',
            'Giá bán',
            'Mã loại',
            'Số lượng tồn kho',
            'Ngày nhập',
            'Đơn vị',
            'Hình ảnh'
        ];
    }
}
