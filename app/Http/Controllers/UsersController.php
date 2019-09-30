<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Mail;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth',[
            'except'    =>  [
                'show','create','store','index','confirmEmail'
            ],
        ]);

        $this->middleware('guest',[ //只有未登录用户能访问
            'only'  =>  ['create']
        ]);
    }

    public function index(){
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

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
            'password'=>bcrypt($request->password),
        ]);
        $this->sendConfirmMailToUser($user);
        session()->flash('success','注册成功，请登陆您的注册邮箱验证完成注册');
        return redirect()->route("users.show",[$user]);
    }

    /**
     * @param User $user
     * 用户资料编辑
     */
    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.edit',compact('user'));
    }

    /**
     * 更新用户资料
     */
    public function update(Request $request,User $user){
        $this->authorize('update',$user);
        $this->validate($request,[
            'name'  => 'required|max:50',
            'password'  =>  'nullable|confirmed|min:6',
        ]);

        $data = ['name'=>$request->name];
        if ($request->password){
            $data['password'] = $request->password;
        }
        $user->update($data);
        session()->flash('success','用户信息修改成功');

        return redirect()->route("users.show",$user->id);
    }

    /**
     * 删除用户
     */
    public function destroy(User $user){
        $this->authorize('destroy',$user);
        $user->delete();
        session()->flash('info','删除成功');
        return back();
    }

    /**
     * 验证注册用户
     */
    public function confirmEmail($token){
        $user = User::where("activation_token",$token)->firstOrFail();
        $user->activation_token = null;
        $user->activated = true;
        $user->save();
        session()->flash('success','验证成功！');
        Auth::login($user);
        return redirect()->route('users.show',compact('user'));
    }

    /**
     * 发送注册验证邮件到用户
     */
    private function sendConfirmMailToUser(User $user){
        $view = 'emails.confirm';
        $data = compact('user');
        $name = 'ruanwenwu';
        $from = '379879523@qq.com';
        $to   = $user->email;
        $subject = '感谢注册微博，请验证您的邮箱';
        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject){
            $message->to($to)->subject($subject);
        });

    }

}
