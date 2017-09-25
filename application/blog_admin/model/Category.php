<?php

namespace app\blog_admin\model;

use houdunwang\arr\Arr;
use think\Model;
use think\Validate;

class Category extends Model
{
    protected $pk = 'cate_id';
    protected $table = 'blog_category';

    public function store($data)
    {
        $validate = new Validate([
            'cate_name' => 'require',
            'cate_sort' => 'require|number|between:1,9999',
        ], [
            'cate_name.require' => '请填写栏目名称',
            'cate_sort.require' => '请输入排序规则',
            'cate_sort.number' => '排序必须为数字',
            'cate_sort.between' => '排序范围必须在1-9999',
        ]);
        if (!$validate->check($data)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        $res = $this->save($data);
        if (!$res) {
            return ['valid' => 0, 'msg' => '栏目添加失败'];
        } else {
            return ['valid' => 1, 'msg' => '栏目添加成功'];
        }
    }

    /*
     * 得到数据列表
     */
    public function cate_list()
    {
        $categories = Arr::tree($this->order('cate_sort desc', 'cate_id')->select(), 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
        //$categories= $this->paginate(5);
        return $categories;
    }
    public function getCateData($cate_id)
    {
        $cate_ids= $this->getSon($this->select(),$cate_id);
        //将自己添加进去
        $cate_ids[]=$cate_id;
       // halt($cate_ids);
        $field= db('category')->whereNotIn('cate_id',$cate_ids)->select();
        return Arr::tree($field, 'cate_name', $fieldPri = 'cate_id', $fieldPid = 'cate_pid');
       // halt($field);
    }
    /*
     * 找子集
     */
    public function getSon($data,$cate_id)
    {
        static $temp=[];
        foreach ($data as $v)
        {
            if ($cate_id==$v['cate_pid'])
            {
                $temp[]=$v['cate_id'];
                $this->getSon($data,$v['cate_id']);
            }
        }
        return $temp;
    }

    /*
     * 编辑
     */
    public function edit($data)
    {
        $validate = new Validate([
            'cate_name' => 'require',
            'cate_sort' => 'require|number|between:1,9999',
        ], [
            'cate_name.require' => '请填写栏目名称',
            'cate_sort.require' => '请输入排序规则',
            'cate_sort.number' => '排序必须为数字',
            'cate_sort.between' => '排序范围必须在1-9999',
        ]);
        if (!$validate->check($data)) {
            return ['valid' => 0, 'msg' => $validate->getError()];
        }
        $result = $this->save($data,[$this->pk=>$data['cate_id']]);
        if ($result)
        {
            return ['valid'=>1,'msg'=>'编辑成功'];
        }
        else
        {
            return ['valid'=>0,'msg'=>$validate->getError()];
        }
    }
    public function del($cate_id)
    {
        //获取当前删除数据的pid
        $cate_pid=$this->where('cate_id',$cate_id)->value('cate_pid');
        //halt($cate_pid);
        //将删除的$cate_id的子集数据  pid修改成$cate_pid
        $this->where('cate_pid',$cate_id)->update(['cate_pid'=>$cate_pid]);

        $res= Category::destroy($cate_id);
        if ($res)
        {
            return ['valid'=>1,'msg'=>'删除成功'];
        }
        else{
            return ['valid'=>0,'msg'=>'删除失败'];
        }
    }
}
