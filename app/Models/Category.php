<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class Category extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'category_name',
        'category_slug',
        'category_description',
        'category_file',
        'category_mate_name',
        'category_mate_description',
        'category_mate_keyword',
        'category_status'
    ];

    public static function getCategories($request) {
        $limit = $request->limit;
        $categories = self::orderBy('id', 'DESC')->limit($limit);

        if($request->last_id)
        {
            $categories->where('id', '<', $request->last_id);
        }

        return $categories->get();
    }

    public static function submit($request)
    {
        // save all request in param to add late
        $params = [
            'category_name'             => $request->category_name,
            'category_description'      => $request->category_description,
            'category_mate_name'        => $request->category_meta_name,
            'category_mate_description' => $request->category_meta_description,
            'category_mate_keyword'     => $request->category_meta_ketword
        ];

        // check this has file
        $image = $request->file('category_file');
        if($image)
        {
            $image_name = Str::random(9);
            $image->move('images/categories/', $image_name);
            $params['category_file'] = $image_name;
        }

       $category_id = $request->category_id;
       if(!$category_id)
       {
        $params['category_slug'] = $image_name;

       $status = self::create($params);

        $category_id = $status->id;
       }
       else
       {
        $data = self::where('id', $category_id)->first();
        if($image && $data->category_file)
        {
            File::delete('images/categories/'. $data->category_file);
        }
        $status = self::where('id', $category_id)->update($params);
       }

       $record = self::where('id', $category_id)->first();

       echo json_encode([
        'status' => boolval($status),
        'data'   =>  $record
       ]);
    }

    public static function change($request)
    {
     $status =  $request->category_status  == 0 ? self::where('id', $request->category_id)->update(['category_status' => 1]) :  self::where('id', $request->category_id)->update(['category_status' => 0]);
     $record = self::where('id', $request->category_id)->first();
     echo json_encode([
        'status' => boolval($status),
        'data'   =>  $record
       ]);
    }

    public static function getCategoriesS()
    {
        $data = self::where('category_status', 0)->get();
        echo json_encode([
            'status' => boolval($data),
            'data'  => $data
        ]);
    }


    private function uniqidReal($lenght = 12)
    {
        if (function_exists("random_bytes")) {
            $bytes = random_bytes(ceil($lenght / 2));
        } elseif (function_exists("openssl_random_pseudo_bytes")) {
            $bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
        } else {
            throw new \Exception("no cryptographically secure random function available");
        }
        return substr(bin2hex($bytes), 0, $lenght);
    }
}