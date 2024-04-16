<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function load(Request $request)
    {
        echo Product::fetch($request);
    }

    public function index()
    {
        $categories = Category::where('category_status', 0)->get();
        $brands     = Brand::where('brand_status', 0)->get();

        return view('admin.products.index', compact('categories', 'brands'));
    }

    public function submit(Request $request)
    {
        $request->validate([
            'category'              => 'required|numeric',
            'product_name'          => 'required|string',
            'brand'                 => 'required|numeric',
            'product_descrpiton'    => 'required|string',
            'meta_title'            => 'required',
            'meta_ket'              => 'required',
            'meta_descrption'       => 'required',
            'origin_price'          => 'required',
            'selling_price'         => 'required',
            'quintity'              => 'required|numeric'
        ]);

        return Product::submit($request);

    }
}