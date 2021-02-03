<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    /**
     * Show all orders (only admins or employees)
     */
    public function index() {
        $orders = Order::get_all_orders();
        return view('admin_order.index', ['orders' => $orders]);
    }
    
    /**
     * Sort orders by user, date or status
     */
    public function sort_orders(Request $request){
        return view('order.all-orders');
    }
}
