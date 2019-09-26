<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    //注册
    public function create(){
        return view('users/create');
    }

    /**
     * 显示用户信息
     */
    public function show(User $user){
        return view('users.show',compact('user'));
    }

    /**
     * 存储用户信息
     */
    public function store(Request $request){
        $this->validate($request,[
            'name'  =>  'required|max:5',
            'email' =>  'required|email|unique:users|max:255',
            'password'=>'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name'  =>  $request->name,
            'email' =>  $request->email,
            'password'=>$request->password,
        ]);

        session()->flash('success','注册成功');

        return redirect()->route("users.show",[$user]);
    }
}
