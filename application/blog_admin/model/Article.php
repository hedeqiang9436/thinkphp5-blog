<?php

namespace app\blog_admin\model;

use think\Loader;
use think\Model;

class Article extends Model
{
    protected $pk='art_id';
    protected $table='blog_article';
    protected $auto=['admin_id'];
    protected $insert=['art_create_at'];
    protected $update=['art_update_at'];
    protected function setAdminIdAttr()
    {
        return session('user_id');
    }
    protected function setArtCreateAtAttr()
    {
        return time();
    }
    protected function setArtUpdateAatAttr()
    {
        return time();
    }

    public function store($data)
    {
        if (!isset($data['tag']))
        {
            return ['valid'=>0,'msg'=>'请选择标签名称'];
        }
        // 调用当前模型对应的User验证器类进行数据验证
        $result = $this->validate(true)->allowField(true)->save($data);
        if(false === $result){
            // 验证失败 输出错误信息
            return ['valid'=>0,'msg'=>$this->getError()];
        }
        else{
            //添加文章标签中间表
            foreach ($data['tag'] as $v)
            {
                $arc_tag_data=[
                    'arc_id'=>$this->art_id,
                    'tag_id'=>$v
                ];
                (new Arc_tag())->save($arc_tag_data);
            }
            return ['valid'=>1,'msg'=>'文章添加成功'];
        }

    }
}
