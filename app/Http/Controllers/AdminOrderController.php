<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use DateTime;
use DateInterval;

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

    public function search_orders(Request $request) {
        
        $user = $request->order_search_by_user == "none" ? 0 : $request->order_search_by_user;
        $start_date = $request->order_search_start_date;
        
        $end_date = $request->order_search_end_date;
        empty($end_date) ? $end_date = date('Y-m-d') : $end_date;
        $end_date = DateTime::createFromFormat('Y-m-d', $end_date);
        $end_date->add(new DateInterval('P1D')); // Add one day so the query results include the selected day
        $end_date = $end_date->format('Y-m-d'); // Remove the time and return a simple date string
        print_r($end_date);
        
        $orders_result = Order::search_orders($user, $start_date, $end_date);

        $users = User::get_all_users()->get();
        return view('admin_order.index', ['orders' => $orders_result, 'users' => $users]);
    }

    public function order_update_status(Request $request)
    {
        $response = array(
            'status' => 'success',
            'message' => $request->new_status, //change to a success/error message
        );
        return response()->json($response);
    }
}
