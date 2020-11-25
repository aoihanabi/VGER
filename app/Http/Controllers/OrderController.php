<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
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
        $process_orders = Order::get_in_process_orders();
        //print_r($process_orders);
        return view('order.index', ['p_orders' => $process_orders]);
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
        $this->send_email('El total de su compra es ' . $total . ' haha. Gracias');
        
        return redirect()->action([ProductController::class, 'index']); //not really reloading from this one, it's doing it from calculation.js after post
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
        $order = Order::find($id);
        $details = Order::get_order_details($order->id);
        
        //DB::enableQueryLog();
        //dd(DB::getQueryLog());
        return view('order.show', ['order' => $order, 'details' => $details]);
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

    /**
     * Sends an email to a hardcoded destinatary
     * @param string $body 
     */
    public function send_email($body) {
        $details = [
            'title' => 'Su pedido se realizó con éxito!',
            'body' => $body #'Nos complace informarle que su pedido fue recibido, se encuentra en proceso y se lo enviaremos en los próximos 2 días'
        ];
        Mail::to('abii98cm@gmail.com')->send(new \App\Mail\Mailer($details));
    }
}
