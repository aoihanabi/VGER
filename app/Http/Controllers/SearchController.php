<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        $users = User::get_all_users()->where("id", "!=", Auth::user()->id)->orderBy('role', 'ASC')->get(); 

        //return view('product.index', ['products' => $products, 'main_imgs' => $mains]);
    }
}
