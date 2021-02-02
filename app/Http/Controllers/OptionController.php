<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;
use App\Models\Option;

class OptionController extends Controller
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.vip');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::all();
        $attributes = Attribute::get_all_attributes();
        return view('option.index', ['options' => $options, 'attributes' => $attributes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $attributes = Attribute::get_all_attributes()->pluck('name', 'id');
        return view('option.create', [
                                    'attributes' => $attributes,
                                    'option' => null
                                    ]);
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
            'option' => 'required|max:20',
            'attribute_id' => 'required',
        ]);
        $option = new Option;
        $option->attribute_id = $request->attribute_id;
        $option->option = $request->option;
        $option->save();
        return redirect()->action([OptionController::class, 'index']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $option = Option::find($id);
        $attributes = Attribute::get_all_attributes()->pluck('name', 'id');
        return view('option.edit', [
                                    'attributes' => $attributes,
                                    'option' => $option
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
            'option' => 'required|max:20',
            'attribute_id' => 'required',
        ]);
        $option = Option::find($id);
        $option->option = $request->option;
        $option->attribute_id = $request->attribute_id;        
        $option->save();
        return redirect()->action([OptionController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $option = Option::find($id);
        $option->delete();
        return redirect()->action([OptionController::class, 'index']);
    }
}
