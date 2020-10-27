<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Image;
use App\Models\Attribute;

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

  public function main_image() 
  {
    return $this->hasMany(Image::Class)->where('type', 'MN');
  }

  public function values() 
  {
    return $this->belongsToMany(Attribute::Class, 'values')->withPivot('option_id');
  }
}
