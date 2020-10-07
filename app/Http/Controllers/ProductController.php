<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Image;

class ProductController extends Controller
{
    public function show_data() {

        $products = Product::all();

        return view('test', ['products' => $products]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::where('prd_status', 'D')->get();
        
        $mains = array();
        foreach ($products as $p) {
            $image = Product::find($p->prd_id)->main_image->first();
            array_push($mains, $image->img_url);
        }

        return view('product.index', ['products' => $products, 'main_imgs' => $mains]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product;
        $product->prd_name = $request->name;
        $product->prd_description = $request->description;
        $product->prd_quantity = $request->quantity;
        $product->prd_price = $request->price;
        $product->save();

        //$prod = App\Models\P::find(1);

        $product->images()->saveMany([
            new Image(['img_url' => 'false_image'], ['img_type' => 'PR']),
            new Image(['img_url' => 'false_image2'], ['img_type' => 'SC']),
        ]);
        $product->refresh();
        
        return redirect()->action([ProductController::class, 'index']);;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        #$imgs = array();
        $imgs = Product::find($id)->images;
        return view('product.show', ['prod' => $product, 'imgs' => $imgs]);
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
