<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use App\Models\User;
use Auth;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function store(Request $request){
        $this->validate($request,[
            'content'   =>  'required|max:140|min:4'
        ]);

        $user = Auth::user();
        $user->statuses()->create([
            'content'   =>  $request->content
        ]);

        return redirect()->back();
    }
}
