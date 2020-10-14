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
        $products = Product::where('status', 'D')->get();
        
        $mains = array();
        foreach ($products as $p) {
            $image = Product::find($p->id)->main_image->first();
            array_push($mains, $image->url);
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
        return view('product.create', ['product' => null] );
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
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();

        $this->upload_product_images($request, $product);
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
        $imgs = Product::find($id)->images;
        return view('product.show', ['product' => $product, 'imgs' => $imgs]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        return view('product.edit', ['product' => $product]);
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
        $product = Product::find($id);
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();

        $old_main = $product->images()->where('type', 'MN')->first();
        $old_main->delete();
        $this->upload_product_images($request, $product);
        
        $product->refresh();
        return redirect()->action([ProductController::class, 'index']);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->action([ProductController::class, 'index']);
    }

    /*
     * Upload image to the server and saves its url to DB
     */
    public function upload_product_images($request, $product) {

        if($request->hasfile('main_image'))
        {
            $path_main = $request->file('main_image')->store('images/products');
            $im_main = new Image(['url' => $path_main, 'type' => 'MN']);
            
            $product->images()->save($im_main);
        }

        if($request->hasfile('sec_images')) {
            foreach($request->file('sec_images') as $file)
            { 
                $path_sec = $file->store('images/products');
                $im_sec = new Image(['url' => $path_sec, 'type' => 'SC']);

                $product->images()->save($im_sec);
            }    
        }
        
    }
}
