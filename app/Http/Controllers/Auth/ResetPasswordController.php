<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    //重设密码表单
    public function showResetForm($token){
        $password = PasswordReset::where('token',$token)->firstOrFail();
        $email = $password->email;
        return view('password.resetform',['token'=>$token,'email'=>$email]);
    }

    //重置密码
    public function reset(Request $request){
        //校验字段
        $this->validate($request,[
            'email' =>  'required|email|max:255',
            'password'  =>  'required|min:6|confirmed',
            'token' =>  'required'
        ]);

        $password = PasswordReset::where('token',$request->token)->firstOrFail();

        $user = User::where('email',$password->email)->first();
        $user->update(['email'=>$request->email,'password'=>bcrypt($request->password)]);
        session()->flash('success','密码修改成功');
        return redirect()->route('users.show',[$user]);
    }

}
