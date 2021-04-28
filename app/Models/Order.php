<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    /**
     * Retrieve all orders from the DB
     */
    public static function get_all_orders() 
    {
        return DB::table('orders')
                    ->join('users', 'orders.user_id', '=', 'users.id')
                    ->select('orders.id', 'orders.total', 'orders.date', 'orders.status', 'orders.user_id', 'users.name')
                    ->orderBy('orders.updated_at', 'desc')
                    ->get();
    }

    /**
     * Retrieve all orders of the authenticated user from the DB
     */
    public static function get_user_orders() 
    {
        //Auth::user()->id
        
        return Order::where([
            ['user_id', Auth::user()->id]
        ])->orderBy('updated_at', 'desc')
        ->paginate(7);
    }

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
     * Retrieve all details(products) of one order
     */
    public static function get_order_details($order_id) 
    {
        // $opts = Option::select('options.attribute_id', 'options.option')
        //                 ->join('values', 'options.id', '=', 'values.option_id')
        //                 ->where('values.product_id', '=', $id)->get();
        return DB::table('orderdetails')->select('products.name', 'orderdetails.subtotal', 'orderdetails.purchased_quantity', 'orderdetails.description')
                                        ->join('products', 'orderdetails.product_id', '=', 'products.id')
                                        ->where('order_id', $order_id)->get();
    }
    
    /**
     * The products that belong to the order.
     */
    public function products()
    {
        return $this->belongsToMany(Product::Class, 'orderdetails')->withPivot('subtotal')->withTimestamps();
    }
}
