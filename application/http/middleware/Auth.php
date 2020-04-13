<?php

namespace app\http\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use think\exception\TokenException;
use think\exception\ValidateException;
use think\facade\Cache;
use think\facade\Config;

class Auth
{
    public function handle($request, \Closure $next)
    {
        $bearer_token = [];
        $bearer = $request->header("Authorization");
        if ($bearer !== null){
            $bearer_token = $bearer;
        }
        if (empty($bearer_token)) {
            //匹配不到结果尝试去url中获取
            if ($request->param('token') !== null) {
                $token = $request->param('token');
            }else{
                throw new TokenException('请登录', 401);
            }
        }else{
            $token=$bearer_token;
        }

        try{
            $de_token = JWT::decode($token,Config::get('JWT_KEY'),Config::get('JWT_ENCRYPTION'));

        } catch (SignatureInvalidException $exception){
            throw new TokenException('无效的令牌',401);
        } catch (\Exception $exception){
            throw new TokenException('请重新登录', 401);
        }

        if ($de_token->voe < time() && $de_token->exp > time()){
            throw new TokenException('请换取新令牌', 402);
        }else if ($de_token->voe < time()) {
            throw new TokenException('请重新登录', 401);
        }

        if (Cache::get('login_token_' . $de_token->data->uid) != $token) {
            throw new TokenException('用户信息错误，请重新登录', 401);
        }

        if ($de_token->data->is_ban == 1){
            throw  new ValidateException('该用户已经被封禁');
        }
        $request->auth = $de_token->data;
        return $next($request);
    }
}
