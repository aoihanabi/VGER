<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;

    /**
     * The products that belong to the category.
     */
    public function products()
    {
        return $this->belongsToMany(Product::Class, 'prodxcateg')->withTimestamps();
    }
}
