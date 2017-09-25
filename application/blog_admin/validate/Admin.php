<?php
namespace app\blog_admin\validate;
use think\Validate;

class Admin extends Validate
{
    protected $rule=[
        'email'=>'require',
        'password'=>'require',
        'code'=>'require|captcha'
    ];
    protected $message=[
        'email.require'=>'邮箱不能为空',
        'password.require'=>'密码不能为空',
        'code.require'=>'验证码不能为空',
        'code.captcha'=>'验证码不正确'
    ];
}