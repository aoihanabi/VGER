<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    /**
     * Retrieve all orders in 'in porcess' of the authenticated user from the DB
     */
    public static function get_in_process_orders() 
    {
        //Auth::user()->id
        
        return Order::where([
            ['user_id', Auth::user()->id],
            ['status', 'P']
        ])->get();
    }
    
    /**
     * The products that belong to the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::Class, 'orderdetails')->withPivot('subtotal')->withTimestamps();
    }
}
