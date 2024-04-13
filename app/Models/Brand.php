<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'brand_slug',
        'brand_status'
    ];

    public static function submit($request)
    {
        $brand_id = $request->band_id;
        $slug = Str::random(8);
        $data = ['brand_name' => $request->brand_name, 'brand_slug' => $slug];
        $status = $brand_id == null ? self::create($data) : self::where('id', $brand_id)->update($data);
        $record = self::where('id', $request->brand_id)->first();
        echo json_encode([
          'status' => boolval($status),
          'data'   =>  $record
        ]);
    }
}