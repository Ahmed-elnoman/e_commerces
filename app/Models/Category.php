<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public static function getCategories() {
        return self::orderBy('create_at', 'DESC');
    }
}