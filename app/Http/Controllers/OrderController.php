<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Lang;
use \Exception;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductOptions;
use App\Mail\OrderProcessed;

class OrderController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth.vip')->only(['all_orders', 'sort_orders']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $process_orders = Order::get_user_orders();
        //print_r($process_orders);
        return view('order.index', ['p_orders' => $process_orders]);
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
            //print_r($full_order);
            
            if(!empty($full_order)) {
                
                $total = 0;
                $order = new Order;
                $order->date = now();
                $order->user_id = Auth::user()->id;
                $order->total = 0;
                // $order->save();

                $ord_id = Order::latest()->first();
                
                foreach($full_order as $prod) {
                    
                    $product = Product::find($prod->id, ['id']);
                    
                    foreach($prod->details as $detail) {
                        
                        $description = "";
                        $wheres = array();
                        foreach($detail->description as $key => $option_item) {
                            // Create the product description for the order
                            $description .= $option_item->label . " ";
                            
                            // Build the 'where clause' with the color, talla, estilo ids, to find the specific product option
                            $wheres[] = ["options_ids->{$key}->id", $option_item->id];
                        }
                        $productOption = ProductOptions::where('product_id', $product->id)
                                        ->where($wheres)->first(); 
                        $productOption->amount = $detail->option_amount_left; //Update specific product option amount left
                        $productOption->save();

                        $purchased_quantity = $detail->cart_amount;
                        $subtotal = $detail->total_price;
                        $product->orders()->attach($ord_id->id, ['subtotal' => $subtotal, 'purchased_quantity' => $purchased_quantity, 'description' => $description]);
                        
                        $total += $subtotal;
                    }
                    
                    $product->quantity = $prod->quantityLeft; // Update the general product amount left
                    $product->save();
                }
                $order->total = $total;
                $order->save();

                // // send_email('Su pedido se realizó con éxito!',
                // //             'El total de su compra es ' . $total . ' haha. Gracias',
                // //             Auth::user()->email);
                $details = Order::get_order_details($order->id);
                Mail::to(Auth::user()->email)->send(new OrderProcessed($order, $details));
                $request->session()->flash('order_notification', "¡Pedido procesado con éxito!");
            }
            //return response($t);
            //return redirect()->action([OrderController::class, 'index'], 200)->with('order_notification', 'Pedido procesado con éxito');
            
        } else {
            //session(['url.intended' => url()->previous()]);
            //return response()->json(["url" => "/login"], 401);
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
