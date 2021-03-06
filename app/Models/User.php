<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function boot(){
        parent::boot(); //模型类初始化之后加载，事件监听都放在这里
        static::creating(function($user){   //模型被创建之前执行
            $user->activation_token = Str::random(10);
        });
    }

    //获取用户头像
    public function gravatar($size = '140'){
        $hash = md5(strtolower($this->attributes['email']));
        return "http://www.gravatar.com/avatar/$hash?s=$size";
    }

    //指明一个用户拥有多条微博
    public function statuses(){
        return $this->hasMany(Status::class);
    }

    public function feed(){
        return $this->statuses()->orderBy('created_at','desc');
    }
}
