<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CategoryController extends Controller
{
    public function show($maLoai)
    {
        $products = Product::where('maLoai', $maLoai)->get();
        return view('products.category', compact('products', 'maLoai'));
    }
}
