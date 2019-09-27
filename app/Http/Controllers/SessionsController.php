<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //会话创建
    public function create(){
        return view('sessions.create');
    }

    //保存会话
    public function store(Request $request){
        $credentials = $this->validate($request,[
            'email'     =>'required|email|max:255',
            'password'  =>'required|min:6',
        ]);

        if(Auth::attempt($credentials)){
            session()->flash('success','欢迎回来');
            return redirect()->route('users.show',[Auth::user()]);
        }else{
            session()->flash('danger','邮箱或者密码错误');
            return redirect()->back()->withInput();
        }
    }

    /**
     * 删除会话
     */
    public function destroy(){
        Auth::logout();
        session()->flash('info','您已经成功退出');
        return redirect()->route("login");
    }
}
