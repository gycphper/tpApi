<?php
/**
 * Created by PhpStorm.
 * User: lihongjie
 * Date: 2019/8/22
 * Time: 22:41
 */

namespace app\common;


class help
{
    public static function susJsonReturn( $data=[], $msg='请求成功', $code=1)
    {
        return json([
            'msg'=>$msg,
            'data'=>$data,
            'code'=>$code
        ]);
    }
    public static function errJsonReturn( $msg = '请求失败', $code = 0,$data = [])
    {
        return json([
            'msg'=>$msg,
            'data'=>$data,
            'code'=>$code
        ]);
    }
}