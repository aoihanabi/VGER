<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = user_roles();
        unset($roles['user']);
        
        return view('user.create', ['user' => null, 'roles' => $roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = new User;
        $user->name = $request->name;
        $user->role = $request->role;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $pass = string_generator(10);
        $user->password = Hash::make($pass);
        
        $user->save();

        send_email('Usuario de Ventas Gerizim disponible',
                    'Tu usuario para Ventas Gerizim está listo, puedes acceder usando la contraseña '. $pass .' 
                    Asegúrate de cambiarla tras el primer ingreso para garantizar la seguridad de la cuenta.',
                    $request->email);
        
        return redirect()->action([UserController::class, 'index']);
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
        $roles = user_roles();
        
        #print_r($roles);
        return view('user.edit', ['user' => $user, 'roles' => $roles]);
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
        $user = User::find($id);
        $user->name = $request->name;
        $user->role = $request->role;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->save();
        
        return redirect()->action([UserController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->action([UserController::class, 'index']);
    }
}