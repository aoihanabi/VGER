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
        //echo($orders);
        return view('admin_order.index', ['orders' => $orders]);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $order = Order::find($id);
            $details = Order::get_order_details($order->id);
            
            //DB::enableQueryLog();
            //dd(DB::getQueryLog());
            return view('order.show', ['order' => $order, 'details' => $details]);
        } catch (Exception $e) {
            return redirect()->action([OrderController::class, 'index'])->withErrors([Lang::get('validation.order_not_found')]);
        }
    }
    
    /**
     * Sort orders by user, date or status
     */
    public function sort_orders(Request $request){
        return view('order.all-orders');
    }
}
