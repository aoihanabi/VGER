<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\ProductController;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'orders index being called';
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $full_order = (array)json_decode($request->order);
        #print_r($full_order);
        
        if(!empty($full_order)) {
            $total = 0;
            $order = new Order;
            $order->total = $total;
            $order->date = now();
            $order->user_id = 1;
            $order->save();

            $ord_id = Order::latest()->first();
            #echo('ord id: ' . $ord_id);
            foreach($full_order as $prod) {

                $product = Product::find($prod->id, ['id', 'name', 'quantity', 'price']);
                $subtotal = $product->price * $prod->cart_quantity;
                $total += $subtotal;
                $product->orders()->attach($ord_id->id, ['subtotal' => $subtotal]);

                #echo('Eem:'.$product->price . ' * ' . $prod->cart_quantity);
                #echo('Subtotal:'.$subtotal . '-> ' . $total);
                #echo('<br />');
            }
            $order->total = $total;
            $order->save();
        }
        
        return redirect()->action([ProductController::class, 'index']);//not really reloading from this one, it's doing it from calculation.js after post
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
