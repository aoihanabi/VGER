<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;

class Image extends Model
{
  use HasFactory;
  protected $fillable = ['url', 'type'];


  /**
   * Get the product that owns the image.
   */
  public function product()
  {
      return $this->belongsTo(Product::class);
  }
}
