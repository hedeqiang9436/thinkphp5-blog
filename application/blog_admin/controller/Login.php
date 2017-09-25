<?php

namespace app\blog_admin\controller;

use think\Controller;
use app\blog_admin\model\User;
use houdunwang\crypt\Crypt;
use think\Request;

class Login extends Controller
{
    /**
     * 登陆
     */
    public function login()
    {
        //echo Crypt::encrypt('admin888');
        //echo Crypt::decrypt('h3vPU8JGuF3VS/uxIpjRSw==');
        if (request()->isPost()){
            $res=(new User())->login(input('post.'));
            if ($res['valid']){
                return $this->success($res['msg'],'blog_admin/index/index');
            }
            else{
                return $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }
    /**
     * 注册
     */
    public function register()
    {
        if (\request()->isPost()){
            $res=(new User())->register(input('post.'));
            if ($res['valid']){
                return $this->success($res['msg'],'blog_admin/index/index');
            }
            else{
                return $this->error($res['msg']);exit;
            }
        }
        return $this->fetch();
    }
}
