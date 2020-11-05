<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    
    /**
     * Retrieve all attributes, id and name columns
     */
    public static function get_all_attributes() 
    {
        return Attribute::select('id', 'name')->get();
    }
}
