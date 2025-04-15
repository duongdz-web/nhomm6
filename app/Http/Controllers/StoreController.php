<?php
namespace App\Http\Controllers;
use App\Models\sanpham;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Customer; // ✅ Thêm dòng này

use App\Models\Product;


class StoreController extends Controller
{


    public function index()
    {
        $products = Product::all(); // hoặc limit(20) nếu bạn muốn giới hạn
        return view('home', ['products' => $products, 'header' => 'Trang chủ']);
      
    }
    
    public function chitiet($id)
    {
        $product = Product::where('maSP', $id)->firstOrFail();
        return view('products.chitiet', compact('product'));

    }
    public function sanphamlist(){
        $data = DB::table("sanpham")->get();
        return view("store.sanpham_list",compact("data"));
        }

        public function sanphamcreate()
        {
            $the_loai = DB::table("dm_the_loai")->get();
            $action = "add";
            return view("store.sanpham_form",compact("the_loai","action"));
        }   
}



