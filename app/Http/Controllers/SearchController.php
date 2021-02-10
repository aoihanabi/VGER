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
        //$users = User::get_all_users()->where("id", "!=", Auth::user()->id)->orderBy('role', 'ASC')->get(); 
        $category = $request->input('categ');
        echo($category);
        //echo('| ' . $text);
        //return view('user.index', ['users' => $users]);

        //return view('product.index', ['products' => $products, 'main_imgs' => $mains]);
    }
}
