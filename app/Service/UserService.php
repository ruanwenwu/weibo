<?php
namespace App\Service;

use Mail;
use App\Models\USer;

class UserService{

    /**
     * 发送邮件到用户
     */
    public static function sendConfirmMailToUser(User $user){
        $view = 'emails.confirm';
        $data = compact('user');
        $name = 'ruanwenwu';
        $from = '379879523@qq.com';
        $to   = $user->email;
        $subject = '感谢注册微博，请验证您的邮箱';
        Mail::send($view,$data,function($message) use ($from,$name,$to,$subject){
            $message->from($from,$name)->to($to)->subject($subject);
        });

    }
}