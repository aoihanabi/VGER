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

  public static function search_products($name_or_keyword, $categ_id, $max_price)
  {
    //$categ_id = !empty($categ_id) ? $categ_id : 0;
    //$max_price = !empty($max_price) ? intval($max_price) : 100000;

    // SELECT DISTINCT products.id, products.name 
    //                 FROM `products` 
    //                 INNER JOIN prodxcateg ON products.id = prodxcateg.product_id
    //                 WHERE (prodxcateg.category_id = IFNULL( NULLIF(0,0), prodxcateg.category_id))
    //                 AND (products.name LIKE '%luz%' OR products.keywords LIKE '%luz%')
    //                 AND (products.price < 100000)

    $result = Product::select('products.id', 'products.name')->distinct()
                    ->join('prodxcateg', 'prodxcateg.product_id', '=', 'products.id')
                    ->whereRaw('prodxcateg.category_id = IFNULL(NULLIF('. $categ_id .', 0), prodxcateg.category_id)')
                    ->where(
                      function ($query) use ($name_or_keyword) {
                        $query->where('products.name', 'like', '%'.$name_or_keyword.'%')
                              ->orWhere('products.keywords', 'like', '%'.$name_or_keyword.'%');
                      }
                    )
                    ->where('products.price', '<=', $max_price)
                    ->get();
    
    //echo($result);
    return $result;
    
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
   * Retrieve the attributes that belong to the product's
   */
  public function attributes() 
  {
    return $this->belongsToMany(Attribute::Class, 'product_attributes');
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
