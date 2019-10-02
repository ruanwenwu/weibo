<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'StaticPagesController@home')->name("home");   //首页
Route::get('/about', 'StaticPagesController@about')->name("about");   //关于
Route::get('/help', 'StaticPagesController@help')->name("help");   //帮助
Route::get('/signup','UsersController@create')->name("signup"); //注册
Route::get('/signup/confirm/{token}','UsersController@confirmEmail')->name('confirm_email');//用户激活
Route::resource("users",'UsersController');  //用户资源
Route::get('login','SessionsController@create')->name('login');  //登录页面
Route::post('login','SessionsController@store')->name('login');  //保存会话
Route::delete('logout','SessionsController@destroy')->name('logout');   //删除会话
//密码重设
Route::get('/password/reset','Auth\ForgotPasswordController@reset')->name('password.reset');
Route::post('/password/sendEmail','Auth\ForgotPasswordController@sendEmail')->name('password.sendEmail');
Route::get('/password/reset/{token}','Auth\ResetPasswordController@showResetForm')->name('password.showResetForm');//验证token，重设密码
Route::post('/password/reset','Auth\ResetPasswordController@reset')->name('password.update');//验证token，重设密码
//微博发布与删除
Route::resource("statuses",'StatusesController')->only(['store','delete']);
