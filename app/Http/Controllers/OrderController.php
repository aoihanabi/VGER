<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\Product;

class OrderController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.vip')->only(['all_orders', 'sort_orders']);
    }
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
        if (Auth::check()) {
            $full_order = (array)json_decode($request->order);
            #print_r($full_order);
            
            if(!empty($full_order)) {
                $total = 0;
                $order = new Order;
                $order->total = $total;
                $order->date = now();
                $order->user_id = Auth::user()->id;
                $order->save();

                $ord_id = Order::latest()->first();
                foreach($full_order as $prod) {

                    $product = Product::find($prod->id, ['id', 'name', 'quantity', 'price']);
                    $subtotal = $product->price * $prod->cart_quantity;
                    $total += $subtotal;
                    $product->orders()->attach($ord_id->id, ['subtotal' => $subtotal, 'purchased_quantity' => $prod->cart_quantity]);
                }
                $order->total = $total;
                $order->save();
            }
            $this->send_email('El total de su compra es ' . $total . ' haha. Gracias');
            
            return redirect()->action([ProductController::class, 'index'], 200); //not really reloading from this one, it's doing it from calculation.js after post
        } else {
            session(['url.intended' => url()->previous()]);
            return response()->json(["url" => "/login"], 401);
        }
        
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
     * Show all orders (only admins or employees)
     */
    public function all_orders() {
        return view('order.all-orders');
    }
    
    /**
     * Sort orders by user, date or status
     */
    public function sort_orders(Request $request){
        return view('order.all-orders');
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
        Mail::to(Auth::user()->email)->send(new \App\Mail\Mailer($details));
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
