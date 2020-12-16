<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Order;

class Product extends Model
{
  use HasFactory;
  use SoftDeletes;

  /**
   * Retrieve all products from the DB
   */
  public static function get_all_products() 
  {
    return Product::select('id', 'name', 'description', 'quantity', 'price', 'status')->get();
  }

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
   * Scope to retrieve a product's secondary image.
   */
  public function secondary_images() 
  {
    return $this->hasMany(Image::Class)->where('type', 'SC');
  }

  /**
   * The categories that belong to the product
   */
  public function categories()
  {
    return $this->belongsToMany(Category::Class, 'prodxcateg')->withTimestamps();
  }
  
  /**
   * Retrieve a product's attributes
   */
  public function get_product_attributes() 
  {
    return $this->belongsToMany(Attribute::Class, 'product_attribute');
  }

  /**
   * Retrieve a product's options
   */
  public static function get_product_options($prod_id)
  {
    return DB::table('product_options')->select('options_ids', 'amount')->where('product_id', '=', $prod_id)->get();
  }

  /**
   * The values (or properties) that belong to the product
   */
  // public function values() 
  // {
  //   return $this->belongsToMany(Attribute::Class, 'values')->withPivot('option_id')->withTimestamps();
  // }

  /**
   * The orders that belong to the product
   */
  public function orders()
  {
    return $this->belongsToMany(Order::Class, 'orderdetails')->withPivot('subtotal')->withTimestamps();
  }

  

  
}
