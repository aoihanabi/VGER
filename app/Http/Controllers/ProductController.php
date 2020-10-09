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

        /*request()->validate([
            'name' => 'required',
            'author' => 'required',
        ]);*/
        $product = new Product;
        $product->prd_name = $request->name;
        $product->prd_description = $request->description;
        $product->prd_quantity = $request->quantity;
        $product->prd_price = $request->price;
        $product->save();

        if($request->hasfile('main_image') && $request->hasfile('sec_images'))
        {   
            $path_main = $request->file('main_image')->store('products');
            $im_main = new Image(['img_url' => $path_main, 'img_type' => 'PR']);
            echo $im_main;
            $product->images()->save($im_main);
            
            foreach($request->file('sec_images') as $file)
            { 
                $path_sec = $file->store('products');#$request->file('sec_images')->store('products');
                $im_sec = new Image(['img_url' => $path_sec, 'img_type' => 'SC']);
                echo $im_sec;
                $product->images()->save($im_sec);
            }
        }
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
