<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;

class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * Get the images for the product.
   */
  public function images()
  {
    return $this->hasMany(Image::Class);
  }

  /**
   * Scope to retrieve a product's main image.
   */
  public function main_image() 
  {
    return $this->hasMany(Image::Class)->where('type', 'MN');
  }

  /**
   * The categories that belong to the product
   */
  public function categories()
  {
    return $this->belongsToMany(Category::Class, 'prodxcateg')->withTimestamps();
  }
  
  /**
   * The values (or properties) that belong to the product
   */
  public function values() 
  {
    return $this->belongsToMany(Attribute::Class, 'values')->withPivot('option_id')->withTimestamps();
  }
}
