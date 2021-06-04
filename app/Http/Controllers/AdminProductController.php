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

class AdminProductController extends Controller
{
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
        
        $search_categories = Category::get_all_categories()->toArray();

        $max_price = Product::max('price');
        $min_price = Product::min('price');

        return view('admin_product.index', ['products' => $products, 'main_imgs' => $mains, 
                                            'search_categories' => $search_categories,
                                            'min_price' => $min_price,
                                            'max_price' => $max_price]);
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
            print_r($colors);
            return view('admin_product.create', ['product' => null, 
                                                'attrs' => $attrs,
                                                'prod_attributes' => null,
                                                'colors' => $colors, 
                                                'sizes' => $sizes,
                                                'styles' => $styles,                                           
                                                'options' => $options, 
                                                'prod_options' => null, 
                                                'prod_options_amount' => null,
                                                'categories' => $categories,
                                                'prod_categs' => null,
                                                'main_img' => null,
                                                'second_imgs' => null]);
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
        $validated = $request->validate([
            'code' => 'required|numeric|digits:6',
            'name' => 'required|max:150',
            'description' => 'max:350',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'attribute_checks' => 'required',
            'color' => 'required_without_all:talla,estilo',
            'talla' => 'required_without_all:color,estilo',
            'estilo' => 'required_without_all:talla,color',
            'categ_checks' => 'required',
            'main_image' => 'required',
        ]);
        $product = new Product;
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->keywords = $request->keywords;
        $product->save();
        
        #OPTIONS
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
            //print_r($arr);
            $productOption = new ProductOptions;
            $productOption->product_id = $product->id;
            $productOption->options_ids = $toJson;
            $productOption->amount = $request->opt_amount[$i];
            $productOption->save();
        }

        #CATEGORIES
        foreach ($request->categ_checks as $key => $checked_categ) 
        {
            $product->categories()->attach($checked_categ);
        }

        #IMAGES
        $this->upload_product_images($request, $product);
        $product->refresh();
        
        return redirect()->action([AdminProductController::class, 'index']);
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
        // $attrs = Attribute::select('attributes.name', 'attributes.id')
        //                     ->join('product_attributes', 'attributes.id', '=', 'product_attributes.attribute_id')
        //                     ->where('product_attributes.product_id','=', $id)->get();
        $options_db = Product::get_product_options($product->id);
        
        return view('admin_product.show', ['product' => $product,
                                     'main_img' => $main_img, 
                                     'secondary_imgs' => $secondary_imgs, 
                                    //  'attrs' => $attrs, 
                                     'options_db' => $options_db]);
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
        $colors = Option::get_options_by_attribute(1);
        $sizes = Option::get_options_by_attribute(2);
        $styles = Option::get_options_by_attribute(3);
        $categories = Category::get_all_categories();
        $main_img = $product->main_image->first();
        $second_imgs = $product->secondary_images;

        #Specific product attributes
        $prod_attributes = array();
        foreach ($product->attributes()->get() as $attr) {
            array_push($prod_attributes, $attr->pivot->attribute_id);
        }

        #Specific product options(characteristics) and their corresponding amount
        $prod_options = array();
        $prod_options_amount = array();
        $all_prod_options = Product::get_product_options($id);
        foreach($all_prod_options as $options_and_amount) {
            
            array_push($prod_options_amount, $options_and_amount->amount);
            $options = json_decode($options_and_amount->options_ids);
            array_push($prod_options, $options);
        }

        #Specific product categories
        $prod_categs = array();
        foreach ($product->categories as $key => $category) {
            array_push($prod_categs, $category->id);
        }
        // A way to have main and secondary images together in one array
        // $imgs_full_url = [];
        // array_push($imgs_full_url, url($main_img->url));
        // foreach ($secondary_imgs as $img) {
        //     array_push($imgs_full_url, url($img->url));
        // }
        return view('admin_product.edit', ['product' => $product, 
                                     'attrs' => $attrs,
                                     'prod_attributes' => $prod_attributes,
                                     'colors' => $colors, 
                                     'sizes' => $sizes,
                                     'styles' => $styles,
                                     'options' => null,
                                     'prod_options' => $prod_options,
                                     'prod_options_amount' => $prod_options_amount,
                                     'categories' => $categories,
                                     'prod_categs' => $prod_categs,
                                     'main_img' => $main_img,
                                     'second_imgs' => $second_imgs
                                     ]);
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
        $validated = $request->validate([
            'code' => 'required|numeric|digits:6',
            'name' => 'required|max:150',
            'description' => 'max:350',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
            'attribute_checks' => 'required',
            'color' => 'required_without_all:talla,estilo',
            'talla' => 'required_without_all:color,estilo',
            'estilo' => 'required_without_all:talla,color',
            'categ_checks' => 'required',
            'keywords' => 'required',
        ]);

        $product = Product::find($id);
        $product->code = $request->code;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->keywords = $request->keywords;
        $product->save();

        #CATEGORIES
        $product->categories()->sync($request->categ_checks);

        #OPTIONS
        $product->attributes()->sync($request->attribute_checks);
        //echo($request->contador);
        for ($i = 0; $i<$request->contador; $i++) {
            $arr = [
                'color' => isset($request->color[$i]) ? ['id' => $request->color[$i], 'option' => Option::where('id', $request->color[$i])->first(['option'])->option] : null,
                'talla' => isset($request->talla[$i]) ? ['id' => $request->talla[$i], 'option' => Option::where('id', $request->talla[$i])->first(['option'])->option] : null,
                'estilo' => isset($request->estilo[$i]) ? ['id' => $request->estilo[$i], 'option' => Option::where('id', $request->estilo[$i])->first(['option'])->option] : null, 
            ];
            
            $toJson = json_encode($arr);
            
            $productOption = ProductOptions::where('product_id', $product->id)->get(); //find?
            echo($i . " | " . PHP_EOL);
            echo(count($request->opt_amount) . PHP_EOL);
            if(isset($productOption[$i])) {

                $productOption[$i]->options_ids = $toJson;
                $productOption[$i]->amount = $request->opt_amount[$i];
                $productOption[$i]->save();
            } else {
                $prodOpt = new ProductOptions;
                $prodOpt->product_id = $product->id;
                $prodOpt->options_ids = $toJson;
                $prodOpt->amount = $request->opt_amount[$i];
                $prodOpt->save();
            }
        }

        #IMAGES
        $this->upload_product_images($request, $product);
        
        $product->refresh();
        return redirect()->action([AdminProductController::class, 'index']);
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
        return redirect()->action([AdminProductController::class, 'index']);
    }

    /*
     * UploadS image to the server and saves its url to DB
     */
    public function upload_product_images($request, $product) {

        if($request->hasfile('main_image'))
        {
            //When updating, Delete if a previous image exists.
            $old_main = $product->main_image->first(); 
            if($old_main) {
                $old_main->delete();
            }
            $path_main = $request->file('main_image')->store('images/products');
            $im_main = new Image(['url' => $path_main, 'type' => 'MN']);
            $product->images()->save($im_main);
        } 
        else if(empty($request->main_image_present)) {
            $validated = $request->validate([
                'main_image' => 'required',
            ]);
        }

        #Check if there are secondary imgs to delete and add more if there is any
        $this->delete_secondary_images($request->sec_images_to_delete);
        if($request->hasfile('sec_images')) {
            
            foreach($request->file('sec_images') as $key => $file)
            {
                // if(isset($old_secondary[$key])) {
                //     $old_secondary[$key]->delete();
                // }
                $path_sec = $file->store('images/products');
                $im_sec = new Image(['url' => $path_sec, 'type' => 'SC']);
                $product->images()->save($im_sec);
            }
        }
    }

    /**
     * When a product its been edited user can delete the secondary images to add new ones or none at all.
     * So this method takes from frontend the id of the images the user deleted, and proceeds to delete them in the database.
     */
    public function delete_secondary_images($imgs_ids) {
        
        if(!empty($imgs_ids)){
            $imgs_ids_array = explode(",", $imgs_ids);
            foreach($imgs_ids_array as $id) {
                Image::find($id)->delete();
            }
        }
    }
    /**
     * Method to update product's quantity only from index page using ajax [NOT USED, LEFT IT FOR FUTURE REFERENCE]
     */
    // public function update_quantity_only() {
    //     $new_quantity = $_POST['new_quantity'];
    //     $prod_id = $_POST['id'];

    //     $product = Product::find($prod_id);
    //     $product->quantity = $new_quantity;
    //     $product->save();

    //     $response = array(
    //         'status' => 'success',
    //         'message' => $prod_id, //change to a success/error message
    //     );
    //     return response()->json($response);
    // }
}
