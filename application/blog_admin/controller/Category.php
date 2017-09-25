<?php

namespace app\blog_admin\controller;

use think\Controller;
use think\Request;

class Category extends Comm
{
    public function index()
    {
        $category=new \app\blog_admin\model\Category();
        $categories=$category->cate_list();
        $page=$category->paginate(5);
        $this->assign('categories',$categories);
        $this->assign('page',$page);
        return $this->fetch();
    }

    /**
     * @return mixed|void
     * 添加栏目
     */
    public function store()
    {
        if (\request()->isPost())
        {
           $res=(new \app\blog_admin\model\Category())->store(input('post.'));
           if ($res['valid']){
                return $this->success($res['msg'],'blog_admin/category/index');
           }
           else{
               return $this->error($res['msg']);

           }
        }
        return $this->fetch();
    }

    /*
     * 添加子类
     */
    public function add_son()
    {
        if (\request()->isPost()){
            $res=(new \app\blog_admin\model\Category())->store(input('post.'));
            if ($res['valid']){
                return $this->success($res['msg'],'blog_admin/category/index');
            }
            else{
                return $this->error($res['msg']);

            }
        }
        $cate_id=input('param.cate_id');
        $category=new \app\blog_admin\model\Category();
        $data=$category->where('cate_id',$cate_id)->find();
        $this->assign('data',$data);
        return $this->fetch();
    }
    /*
     * 编辑
     */
    public function edit()
    {
        $category=new \app\blog_admin\model\Category();
        if (\request()->isPost()){
            $res= $category->edit(input('param.'));
            if ($res['valid'])
            {
                $this->success($res['msg'],'blog_admin/category/index');exit;
            }
            else{
                $this->error($res['msg']);exit;
            }
        }
        $cate_id=input('param.cate_id');


        $cateData=$category->getCateData($cate_id);

        $data=$category->where('cate_id',$cate_id)->find();
        $this->assign('data',$data);
        $this->assign('cateData',$cateData);
        return $this->fetch();
    }
    /*
     * 删除
     */
    public function del()
    {
        $cate_id=input('param.cate_id');
        $res=(new \app\blog_admin\model\Category())->del($cate_id);
        if ($res['valid'])
        {
            $this->success($res['msg'],'index');
        }
        else
        {
            $this->error($res['msg']);
        }
    }
}
