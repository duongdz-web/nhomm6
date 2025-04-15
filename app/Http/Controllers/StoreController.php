<?php
namespace App\Http\Controllers;
use App\Models\sanpham;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer; // ✅ Thêm dòng này

use App\Models\Product;


class StoreController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo truy vấn ban đầu
        $query = Product::with('danhgias');
        
        // Lọc theo khoảng giá nếu có
        if ($request->filled('price_min')) {
            $query->where('giaBan', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('giaBan', '<=', $request->input('price_max'));
        }

        // Lọc theo đánh giá trung bình
        if ($request->filled('rating_min')) {
            $ratingMin = (int) $request->rating_min;

            $query->whereHas('danhgias', function ($q) use ($ratingMin) {
                $q->select(DB::raw('AVG(soSao) as avg_rating'))
                    ->groupBy('maSP')
                    ->havingRaw('AVG(soSao) >= ?', [$ratingMin]);
            });
        }

        // Lọc theo dịch vụ & khuyến mãi
        $promotions = $request->input('promotion', []);
        
        if (in_array('discount', $promotions)) {
            $query->whereColumn('giaBan', '<', 'giaBanGoc');
        }

        if (in_array('in_stock', $promotions)) {
            $query->where('soLuongTonKho', '>', 0);
        }

        if (in_array('fast_shipping', $promotions)) {
            $query->where('vanChuyenNhanh', true);
        }

        // Lấy kết quả phân trang
        $products = $query->simplePaginate(15);

        // Trả về view với danh sách sản phẩm
        return view('home', ['products' => $products, 'header' => 'Trang chủ']);
    }


    public function chitiet($id)
    {
        $product = Product::where('maSP', $id)->firstOrFail();
        return view('products.chitiet', compact('product'));

    }
      
}



