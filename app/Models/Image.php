<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Image extends Model
{
  use HasFactory;
  protected $primaryKey = 'img_id';

  /**
   * Get the product that owns the image.
   */
  public function product()
  {
      return $this->belongsTo(Product::class, 'prod_id');
  }
}
