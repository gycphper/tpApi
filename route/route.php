<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\facade\Route;

Route::rule('/','index/Index/index');
Route::rule('user','index/Index/user');

Route::rule('search','index/Search/index');
Route::rule('getIndex','index/Search/getIndex');

Route::group('account',function (){
    Route::get('/login','login/Login/login')->validate('app\login\validate\Login','login');
});
//需要验证登录
Route::group('api',function (){
    Route::get('/user','index/Index/user');
})->middleware(app\http\middleware\Auth::class);



