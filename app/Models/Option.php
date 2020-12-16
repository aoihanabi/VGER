<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * Retrieve all available options/properties
     */
    public static function get_all_options()
    {
        return Option::select('option', 'attribute_id', 'id')->where('deleted_at', '=', null)->get();
    }

    /**
     * Retrieve options of a certain attribute
     */
    public static function get_options_by_attribute($attr_id) 
    {
        return Option::select('id', 'option')->where('attribute_id', $attr_id)->get();
    }
}
