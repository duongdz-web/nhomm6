<?php

namespace App\Imports;

use App\Models\sanpham;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SanPhamImport implements OnEachRow, WithHeadingRow
{
    protected $count = 0;  // Biến đếm

    public function onRow(Row $row)
    {
        $data = $row->toArray();

        if (empty($data['ma_san_pham'])) {
            \Log::warning('Bỏ qua dòng: thiếu mã sản phẩm. Dữ liệu: ' . json_encode($data));
            return;
        }

        sanpham::updateOrCreate(
            ['maSP' => $data['ma_san_pham']],
            [
                'tenSP' => $data['ten_san_pham'] ?? '',
                'giaNhap' => isset($data['gia_nhap']) ? (float)str_replace(['.', ','], ['', '.'], $data['gia_nhap']) : 0,
                'giaBan' => isset($data['gia_ban']) ? (float)str_replace(['.', ','], ['', '.'], $data['gia_ban']) : 0,
                'maLoai' => $data['ma_loai'] ?? '',
                'soLuongTonKho' => $data['so_luong_ton_kho'] ?? 0,
                'ngayNhap' => $data['ngay_nhap'] ?? null,
                'donVi' => $data['don_vi'] ?? '',
                'hinhanh' => $data['hinh_anh'] ?? null,
            ]
        );

        $this->count++;
    }

    public function __destruct()
    {
        \Log::info("Đã import thành công {$this->count} sản phẩm.");
    }
}
