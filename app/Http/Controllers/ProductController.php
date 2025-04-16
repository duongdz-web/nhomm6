<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($maSP)
    {
        $product = Product::with('danhgias')->where('maSP', $maSP)->firstOrFail();

        return view('products.chitiet', compact('product'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $products = Product::where('tenSP', 'LIKE', '%' . $keyword . '%')->get();

        return view('products.search', compact('products', 'keyword'));
    }
    public function sort(Request $request)
    {
        $query = Product::query();

        // Lọc khoảng giá
        if ($request->filled('price_min') && $request->filled('price_max')) {
            $query->whereBetween('giaBan', [
                (int)$request->price_min, 
                (int)$request->price_max
            ]);
        } elseif ($request->filled('price_min')) {
            $query->where('giaBan', '>=', (int)$request->price_min);
        } elseif ($request->filled('price_max')) {
            $query->where('giaBan', '<=', (int)$request->price_max);
        }

        // Sắp xếp
        switch ($request->sort_by) {
            case 'luot_ban':
                $query->orderByDesc('soLuongDaBan');
                break;
            case 'danh_gia':
                $query->orderByDesc('soSao');
                break;
            case 'gia_tang':
                $query->orderBy('giaBan');
                break;
            case 'gia_giam':
                $query->orderByDesc('giaBan');
                break;
        }

        $products = $query->paginate(12); // nếu có phân trang
        return view('products.category', compact('products'));
    }



}
