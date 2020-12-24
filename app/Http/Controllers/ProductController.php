<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOptions;

class ProductController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.vip')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get_all_products(); 
        
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
            $attrs = Attribute::get_all_attributes();
            $options = Option::get_all_options();
            $categories = Category::get_all_categories();

            $colors = Option::get_options_by_attribute(1);
            $sizes = Option::get_options_by_attribute(2);
            $styles = Option::get_options_by_attribute(3);


            return view('product.create', ['product' => null, 
                                           'attrs' => $attrs,
                                           'colors' => $colors, 
                                           'sizes' => $sizes,
                                           'styles' => $styles,
                                           'prod_attributes' => null,
                                           'options' => $options, 
                                           'prod_options' => null, 
                                           'categories' => $categories,
                                           'prod_categs' => null]);
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
        // ]);*/
        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->save();

        // foreach ($request->opt_checks as $key => $checked_opt) 
        // {
        //     //print_r($request->opt_checks);
        //     $ids = explode(',', $checked_opt); 
        //     //print_r($ids);
        //     $product->values()->attach($ids[0], ['option_id' => $ids[1]]);
        // }
        //print_r($request->attribute_checks);
        foreach ($request->attribute_checks as $attribute) {
           $product->attributes()->attach($attribute); 
        }
        
        for ($i = 0; $i<$request->contador+1; $i++) {
            $arr = [
                'color' => isset($request->color[$i]) ? ['id' => $request->color[$i], 'option' => Option::where('id', $request->color[$i])->first(['option'])->option] : null,
                'talla' => isset($request->talla[$i]) ? ['id' => $request->talla[$i], 'option' => Option::where('id', $request->talla[$i])->first(['option'])->option] : null,
                'estilo' => isset($request->estilo[$i]) ? ['id' => $request->estilo[$i], 'option' => Option::where('id', $request->estilo[$i])->first(['option'])->option] : null, 
            ];
            $toJson = json_encode($arr);
            
            $productOption = new ProductOptions;
            $productOption->product_id = $product->id;
            $productOption->options_ids = $toJson;
            $productOption->amount = $request->opt_amount[$i];
            $productOption->save();
            // DB::enableQueryLog();
            
            // dd(DB::getQueryLog());
        }

        foreach ($request->categ_checks as $key => $checked_categ) 
        {
            $product->categories()->attach($checked_categ);
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
        $main_img = $product->main_image->first();
        $secondary_imgs = $product->secondary_images;
        $attrs = Attribute::select('attributes.name', 'attributes.id')
                            ->join('product_attributes', 'attributes.id', '=', 'product_attributes.attribute_id')
                            ->where('product_attributes.product_id','=', $id)->get();//->distinct()->get();
        
        // $opts = Option::select('options.id', 'options.option', 'options.attribute_id')
        //                 ->join('product_options', 'options.id', '=', 'product_options.options_ids')
        //                 ->where('product_options.product_id', '=', $id)->get();
        $options_db = Product::get_product_options($product->id);

        // foreach ($options_db as $detail) {
        //     echo("amount: " . $detail->amount . "</br>");
        //     $options = (array)json_decode($detail->options_ids);

        //     // foreach ($options as $opt) {
        //     //     foreach((array)$opt as $value) {
        //     //         print_r($value . "</br>");
        //     //     }
        //     // }
        // }
        
       
        return view('product.show', ['product' => $product,
                                     'main_img' => $main_img, 
                                     'secondary_imgs' => $secondary_imgs, 
                                     'attrs' => $attrs, 
                                     'options_db' => $options_db
                                     /*'opts' => $opts*/]);
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
        $attrs = Attribute::get_all_attributes();
        $options = Option::get_all_options();
        $categories = Category::get_all_categories();

        $prod_options = array();
        foreach ($product->values as $val) {
            $prod_opt = DB::table('options')->where('id', $val->pivot->option_id)->value('id');
            array_push($prod_options, $prod_opt);
        }

        $prod_categs = array();
        foreach ($product->categories as $key => $category) {
            array_push($prod_categs, $category->id);
        }

        return view('product.edit', ['product' => $product, 
                                     'attrs' => $attrs, 
                                     'options' => $options, 
                                     'prod_options' => $prod_options,
                                     'categories' => $categories,
                                     'prod_categs' => $prod_categs]);
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
            $old_main = $product->images()->main_image(); //$product->images()->where('type', 'MN')->first();
            $old_main->delete();
        }
        $this->upload_product_images($request, $product);
        
        $product->refresh();
        return redirect()->action([ProductController::class, 'index']);
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

    /**
     * Method to update product's quantity only from index page using ajax
     */
    public function update_quantity_only() {
        $new_quantity = $_POST['new_quantity'];
        $prod_id = $_POST['id'];

        $product = Product::find($prod_id);
        $product->quantity = $new_quantity;
        $product->save();

        $response = array(
            'status' => 'success',
            'message' => $prod_id, //change to a success/error message
        );
        return response()->json($response);
    }
}
