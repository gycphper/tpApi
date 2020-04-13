<?php

namespace app\login\controller;

use app\common\help;
use app\common\service\OperationToken;
use think\Controller;
use think\Db;
use think\Request;

class Login extends Controller
{
    public function login(Request $request){
        $info = Db::name('user')
            ->where(['mobile' => $request->param('mobile'), 'password' => md5($request->param('password'))])
            ->find();
        if ($info == null || empty($info)){
            return help::errJsonReturn('账号或密码错误');
        }

        $token = OperationToken::crearToken($info['id'], $info['uuid'], $info['is_ban']);
        return json([
            'type' => 'Bearer ',
            'access_token'=>$token['token'],
            'exp_time'=>$token['exp'],
            'voe_time'=>$token['voe'],
            'iat_time'=>time()
        ]);
    }
}
