<?php
/**
 * Created by PhpStorm.
 * User: lihongjie
 * Date: 2019/8/22
 * Time: 22:38
 */

namespace app\common\service;
use think\Db;
use think\facade\Cache;
use Firebase\JWT\JWT;
use think\facade\Config;
class OperationToken
{
    public static function crearToken(int $uid, string $uuid, int $is_ban): array
    {
        $time = time();
        $info_token = [
            'iat' => $time,//签发时间
            'voe' => Config::get('TOKEN_VOE',7200) + $time,//换取有效时间
            'exp' => Config::get('TOKEN_EXP',3600)+$time,//有效时间
            'sign' => base64_encode($uuid),//签名
            'data' => [
                'uid' => $uid,//用户id
                'is_ban' => $is_ban,//是否被禁用
            ]
        ];
        $login_token  = Cache::get('login_token_'.$uid);

        if($login_token){
            $token =  $login_token;
        }else{
            $token = JWT::encode($info_token, Config::get('JWT_KEY'));
            Cache::set('login_token_' . $uid, $token, Config::get('TOKEN_VOE',7200));
        }
        return ['token'=>$token, 'voe' =>Config::get('TOKEN_VOE',7200) + $time,'exp' => Config::get('TOKEN_EXP',3600)+$time];
    }
}