<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class StaticPagesController extends Controller
{
    //首页
    public function home(){
        $feedData = [];
        if($user = Auth::user()){
            $feedData = $user->feed()->paginate(30);
        }
        return view('static_pages/home',['feedData'=>$feedData]);
    }
    //关于
    public function about(){
        return view('static_pages/about');
    }
    //首页
    public function help(){
        return view('static_pages/help');
    }
}
