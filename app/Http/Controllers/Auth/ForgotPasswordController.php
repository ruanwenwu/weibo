<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(){
        return view('password.reset');
    }

    public function sendEmail(Request $request){
        $user = User::where('email',$request->email)->first();

        if (!$user){
            session()->flash('danger','邮箱不存在');
            return redirect()->back()->withInput();
        }

        $token = Str::random(10);
        PasswordReset::create(['email'=>$user->email,'token'=>$token,'created_at'=>Carbon::now()]);
        $user->token = $token;

        $data = compact('user');
        $view = 'emails.resetpassword';
        $name = 'rww';
        $from = '379879523@qq.com';
        $to   = $user->email;
        $subject = 'weibo修改密码';
        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject){
            $message->to($to)->subject($subject);
        });
        session()->flash('success','修改密码邮件已发送');
        return redirect()->back()->withInput();
    }
}
