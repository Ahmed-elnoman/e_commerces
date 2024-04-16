<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'product_description',
        'product_original_price',
        'product_selling_price',
        'product_quantity',
        'product_trending',
        'product_status',
        'product_meta_name',
        'product_meta_description',
        'product_meta_key',
        'product_category_id',
        'product_brand_id'
    ];
}