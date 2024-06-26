<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{

    public function load()
    {
        $brands = Brand::orderBy('id', 'DESC')->get();
        echo json_encode($brands);
    }

    public function index()
    {
        return view('admin.brands.index');
    }

    public function submit(Request $request)
    {
        return Brand::submit($request);
    }

    public function changeStatus(Request $request)
    {
        return Brand::changeStatus($request);
    }

    public function getBrands()
    {
        return Brand::getBrands();
    }
}