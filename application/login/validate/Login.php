<?php

namespace app\login\validate;

use think\Validate;

class Login extends Validate
{
    /**
     * 定义验证规则
     * 格式：'字段名'	=>	['规则1','规则2'...]
     *
     * @var array
     */	
	protected $rule = [
	    'mobile'=>'require|mobile',
        'password'=>'require|length:4,12'
    ];
    
    /**
     * 定义错误信息
     * 格式：'字段名.规则名'	=>	'错误信息'
     *
     * @var array
     */	
    protected $message = [
        'mobile.mobile'=>'phone格式错误',
        'password.length'=>'密码长度错误'
    ];

    protected $scene = [
        'login'=>['phone','password']
    ];
}
