<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use DateTime;

class AdminOrderController extends Controller
{
    /**
     * Show all orders (only admins or employees)
     */
    public function index() {
        $orders = Order::get_all_orders();
        $users = User::get_all_users()->get();
        //echo($orders);
        return view('admin_order.index', ['orders' => $orders, 'users' => $users]);
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
            return view('admin_order.show', ['order' => $order, 'details' => $details]);
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
