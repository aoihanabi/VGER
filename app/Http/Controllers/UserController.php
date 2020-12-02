<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get_all_users()->where("id", "!=", Auth::user()->id); 
        
        return view('user.index', ['users' => $users]);
    }

    /**
     * Show the form for editing the specified resource..
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = ['user' => 'Usuario', 'admin' => 'Administrador', 'employee' => 'Empleado'];
        
        #echo("<br> <br>" . $roles);
        
        return view('user.edit', ['user' => $user, 'roles' => $roles]);
    }
}
