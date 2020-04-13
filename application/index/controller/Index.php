<?php
namespace app\index\controller;

use app\index\model\User;
use think\Controller;
use think\Request;

class Index extends Controller
{

    public function index(Request $request){

    }

    public function user(Request $request){
        $data = $request->auth;
        $userInfo = User::findOrFail($data->uid);
        print_r($userInfo);
    }

}