<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The products that belong to the category.
     */
    public function products()
    {
        return $this->belongsToMany(Product::Class, 'prodxcateg')->withTimestamps();
    }

    /**
     * Retrieve all categories, id and name columns
     */
    public static function get_all_categories() 
    {
        return Category::select('id', 'name')->get();
    }
}
