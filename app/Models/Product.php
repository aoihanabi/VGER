<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;

class Product extends Model
{
  use HasFactory;
  protected $primaryKey = 'prd_id';

  /**
   * Get the images for the product.
   */
  public function images()
  {
      return $this->hasMany('App\Models\Image', 'prod_id');
  }
}
