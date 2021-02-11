<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    /**
     * 
     *
     * @return \Illuminate\Http\Response
     */
    public function products_search(Request $request)
    {
        $keyword = $request->input('keyword_search');
        //$category = $request->input('category_search');
        //$price = $request->input('price_search');
        
        //DB::enableQueryLog();
        $keyword_products = Product::search_by_keyword($keyword);
        //dd(DB::getQueryLog());
        
        
        
        // $mains = array();
        // foreach ($keyword_products as $p) {
        //     $image = Product::find($p->id)->main_image->first();
        //     array_push($mains, $image->url);
        // }

        //return view('product.index', ['products' => $keyword_products, 'main_imgs' => $mains]);
    }
}
