<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::where('category_status', 0)->get();
        $brands     = Brand::where('brand_status', 0)->get();

        return view('admin.products.index', compact('categories', 'brands'));
    }
}