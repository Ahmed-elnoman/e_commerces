<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public static function fetch($request)
    {
        $limit = $request->limit;
        $products = DB::table('products')
        ->join('categories', 'products.product_category_id', 'categories.id')
        ->join('brands', 'products.product_brand_id', 'brands.id')
        ->limit($limit);

        if($request->last_id)
        {
            $products->where('id', '<', $request->last_id);
        }

        return $products->get();
    }

    public static function submit($request)
    {
        $params = [
            'product_category_id'       => $request->category,
            'product_name'              => $request->product_name,
            'product_description'       => $request->product_descrpiton,
            'product_original_price'    => $request->origin_price,
            'product_selling_price'     => $request->selling_price,
            'product_quantity'          => $request->quintity,
            'product_meta_name'         => $request->meta_title,
            'product_meta_description'  => $request->meta_descrption,
            'product_meta_key'          => $request->meta_ket,
            'product_brand_id'          => $request->brand,
        ];

        $product_id = $request->product_id;
        if(!$product_id)
        {
            $status = self::create($params);

            $image = $request->file('image');
            if($image)
            {
                $image_name = Str::random(9);
                $image->move('images/products/', $image_name);
            }

            $product_id =  $status->id;
            productImage::create([
                'product_id'  => $product_id,
                'image'       => $image_name,
            ]);

        }
        else {
            $status = self::where('id', $product_id)->update($params);
        }

        echo json_encode([
            'status'  => boolval($status),
            'data'    => $status,
        ]);

    }
}