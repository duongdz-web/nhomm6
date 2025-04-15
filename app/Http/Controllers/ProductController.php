<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($maSP)
    {
        $product = Product::where('maSP', $maSP)->firstOrFail();
        return view('products.chitiet', compact('product'));
    }
    public function search(Request $request)
    {
        $keyword = $request->input('q');

        $products = Product::where('tenSP', 'LIKE', '%' . $keyword . '%')->get();

        return view('products.search', compact('products', 'keyword'));
    }

}
