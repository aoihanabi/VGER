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
        //$this->middleware('auth.vip')->except(['index', 'show']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::get_all_products(); 

        $mains = $this->get_main_images_only($products);
        
        $search_categories = Category::get_all_categories()->toArray();

        $max_price = Product::max('price');
        $min_price = Product::min('price');

        return view('product.index', ['products' => $products, 'main_imgs' => $mains, 
                                      'search_categories' => $search_categories,
                                      'min_price' => $min_price,
                                      'max_price' => $max_price]);
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

    /**
     * Calls a method to search in the database products with the indicated attributes
     * 
     * @return \Illuminate\Http\Response
     */
    public function search_products(Request $request) {
        
        $keyword = $request->keyword_search; 
        $category = $request->category_search == "none" ? 0 : $request->category_search;
        //$price = empty($request->price_search) ? 100000 : intval($request->price_search);
        
        //DB::enableQueryLog();
        $products_result = Product::search_products($keyword, $category, $price);
        //dd(DB::getQueryLog());

        $mains = $this->get_main_images_only($products_result);
        
        $search_categories = Category::get_all_categories()->toArray();

        $max_price = Product::max('price');
        $min_price = Product::min('price');

        return view('product.index', ['products' => $products, 'main_imgs' => $mains, 
                                      'search_categories' => $search_categories,
                                      'min_price' => $min_price,
                                      'max_price' => $max_price]);
    }

    public function get_main_images_only($products) {
        
        $mains = array();
        foreach ($products as $p) {
            $image = Product::find($p->id)->main_image->first();
            array_push($mains, $image->url);
        }
        return $mains;
    }
}
