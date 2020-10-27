<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Image;
use App\Models\Attribute;

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
        $products = Product::all();
        
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
        $user = Auth::user();
        if ($user->can('create', Product::class)) {
            $attrs = Attribute::all();
            $options = DB::table('options')->select('option', 'attribute_id', 'id')->get();
            /*$opciones = DB::table('attributes')
                            ->join('options', 'attributes.id', '=', 'options.attribute_id')
                            ->select('attributes.name', 'options.*')
                            ->get();*/
            return view('product.create', ['product' => null, 'attrs' => $attrs, 'options' => $options, 'prod_options' => null] );
        } else {
            return "Not authorized";
        }
        
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

        foreach ($request->opt_checks as $key => $checked) {
        
            $ids = explode(',', $checked); 
            $product->values()->attach($ids[0], ['option_id' => $ids[1]]);
        }        
        
        $this->upload_product_images($request, $product);
        $product->refresh();
        
        return redirect()->action([ProductController::class, 'index']);
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
        $attrs = Product::find($id)->values;
        return view('product.show', ['product' => $product, 'imgs' => $imgs, 'attrs' => $attrs]);
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
        $attrs = Attribute::all();
        $options = DB::table('options')->select('option', 'attribute_id', 'id')->get();
        $prod_options = array();
        foreach ($product->values as $val) {
            $prod_opt = DB::table('options')->where('id', $val->pivot->option_id)->value('id');
            array_push($prod_options, $prod_opt);
        }
        //print_r($prod_options);
        //echo $product->values; <input type="checkbox" value="{{ $opt->attribute_id }},{{ $opt->id }}" name="opt_checks[{{$k}}]">
        return view('product.edit', ['product' => $product, 'attrs' => $attrs, 'options' => $options, 'prod_options' => $prod_options]);
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

        if ($request->hasfile('main_image')) {
            $old_main = $product->images()->where('type', 'MN')->first();
            $old_main->delete();
        }
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
