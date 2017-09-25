<?php

namespace app\blog_admin\model;

use houdunwang\crypt\Crypt;
use think\Loader;
use think\Model;
use think\Validate;

class User extends Model
{
    protected $pk='id';
    protected $table='blog_user';
    public function login($data)
    {
       //halt($data);
        //1执行验证
        ////3.存入session
        $validate = Loader::validate('Admin');
        if(!$validate->check($data)){
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        //2.比对验证
        $userInfo= $this->where('email',$data['email'])->where('password',Crypt::encrypt($data['password']))->find();
        if (!$userInfo){
            return ['valid'=>0,'msg'=>'用户名或密码不正确'];
        }
        else{
            session('user_id',$userInfo['id']);
            session('email',$userInfo['email']);
            return ['valid'=>1,'msg'=>'登陆成功'];
        }
    }
    public function register($data)
    {
        $validate=new Validate([
            'email'=>'require|email',
            'password'=>'require',
            'confim_password'=>'require|confirm:password'
        ],[
            'email.require'=>'邮箱不能为空',
            'email.email'=>'请输入正确邮箱',
            'password.require'=>'请输入密码',
            'confim_password.require'=>'确认密码不能为空',
            'confim_password.confirm'=>'两次密码不一致'
        ]);
        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        $data=[
            'email'=>$data['email'],
            'password'=>Crypt::encrypt($data['password'])
        ];
        $res= $this->save($data);
        if (!$res){
            return ['valid'=>0,'msg'=>'注册失败'];
        }
        else{
            return ['valid'=>1,'msg'=>'注册成功'];
        }
    }
    public function pass($data)
    {
        //1.验证

        //3.修改

        $validate = new Validate([
            'old-password'  => 'require',
            'new-password'  => 'require',
            'confirm-password'  => 'require|confirm:new-password',
        ],[
            'old-password.require'  => '请输入原始密码',
            'new-password.require'  => '请输入新密码',
            'confirm-password.require'  => '请输入确认密码',
            'confirm-password.confirm'  => '两次密码不一致',
        ]);
        if (!$validate->check($data)) {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
        //2.原始密码是否正确
        $userInfo=$this->where('email',session('email'))->where('password',Crypt::encrypt($data['old-password']))->find();
       if (!$userInfo){
           return ['valid'=>0,'msg'=>'原始密码不正确'];
       }
       //3.修改
        $res= $this->save([
            'password'=>Crypt::encrypt($data['new-password'])
        ],['id'=>session('user_id')]);

       if ($res){
           return ['valid'=>1,'msg'=>'密码修改成功'];
       }
       else{
           return ['valid'=>0,'msg'=>'密码修改失败'];
       }
    }
}
