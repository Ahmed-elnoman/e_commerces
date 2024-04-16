<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('admin/dashboard', function () {
// return view('admin.dashboard');
// });
Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function()
{
    Route::get('/', function() {
        return view('admin.dashboard');
    });

    Route::prefix('categories')->group(function()
    {
        Route::get('/', 'CategoryController@index');
        Route::post('load', 'CategoryController@load');
        Route::match(['post', 'put'], 'submit', 'CategoryController@submit');
        Route::put('change_status', 'CategoryController@changeStatus');
        Route::get('get_categories', 'CategoryController@getCategories');
    });

    Route::prefix('brands')->group(function()
    {
        Route::get('/' , 'BrandController@index');
        Route::post('load', 'BrandController@load');
        Route::match(['post', 'put'], 'submit', 'BrandController@submit');
        Route::put('change_status', 'BrandController@changeStatus');
        Route::get('get_brands', 'BrandController@getBrands');
    });

    Route::prefix('products')->group(function()
    {
        Route::get('/', 'ProductController@index');
    });
});