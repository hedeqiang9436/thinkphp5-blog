<?php

namespace app\blog_admin\model;

use think\Model;
use think\Validate;

class Tag extends Model
{
    //
    protected $pk='tag_id';
    protected $table='blog_tag';
    /*
     * 标签添加
     */
    public function store($data)
    {
        //halt($data);
        $validate = new Validate([
            'tag_name' => 'require',
        ], [
            'tag_name.require' => '请填写标签名称',
        ]);
        if (!$validate->check($data)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        $res = $this->save($data);
        if (!$res) {
            return ['valid' => 0, 'msg' => '标签添加失败'];
        } else {
            return ['valid' => 1, 'msg' => '标签添加成功'];
        }
    }
    /*
     * 标签编辑
     */
    public function edit($data)
    {

        $validate = new Validate([
            'tag_name' => 'require',
        ], [
            'tag_name.require' => '请填写标签名称',
        ]);
        if (!$validate->check($data)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        $result = $this->save([
            'tag_name'=>$data['tag_name'
            ]],[$this->pk=>$data['tag_id']]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'编辑成功'];
        }
        else
        {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
    }

}
