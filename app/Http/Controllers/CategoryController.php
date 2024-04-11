<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequset;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function load(Request $request)
    {
        $categories = Category::getCategories($request);

        echo json_encode($categories);
    }

    public function index()
    {
        return view('admin.categories.index');
    }

    public function submit(CategoryRequset $request)
    {
        Category::submit($request);
    }

    public function changeStatus(Request $request)
    {
        Category::change($request);
    }
}