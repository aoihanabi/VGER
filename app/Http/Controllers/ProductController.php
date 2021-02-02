<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use \Exception;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Image;
use App\Models\Option;
use App\Models\Product;
use App\Models\ProductOptions;

// DB::enableQueryLog();
// dd(DB::getQueryLog());

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $product = Product::find($id);
            $main_img = $product->main_image->first();
            $secondary_imgs = $product->secondary_images;
            $attrs = Attribute::select('attributes.name', 'attributes.id')
                                ->join('product_attributes', 'attributes.id', '=', 'product_attributes.attribute_id')
                                ->where('product_attributes.product_id','=', $id)->get();//->distinct()->get();
            //$attrs = $product->attributes()->get();
            //echo($attrs . PHP_EOL);
            $options_db = Product::get_product_options($product->id);
            //echo($options_db . PHP_EOL);
            return view('product.show', ['product' => $product,
                                        'main_img' => $main_img, 
                                        'secondary_imgs' => $secondary_imgs, 
                                        'attrs' => $attrs, 
                                        'options_db' => $options_db]);
        } catch (Exception $e) {
            return redirect()->action([ProductController::class, 'index'])->withErrors([Lang::get('validation.product_not_found')]);
        }
        
    }
}
