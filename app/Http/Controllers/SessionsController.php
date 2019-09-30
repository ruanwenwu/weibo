<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',[
            'only'  =>  ['create']
        ]);
    }

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

        if(Auth::attempt($credentials,$request->has('remember'))){
            if (Auth::user()->activated) {
                session()->flash('success', '欢迎回来');
                $fallback = route('users.show', Auth::user());
                return redirect()->intended($fallback);
            }else{
                Auth::logout();
                session()->flash('info','请使用邮箱中的链接验证后登陆');
                return redirect('/');
            }
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
