<?php

namespace app\blog_admin\controller;

use think\Controller;
use think\Request;

class Tag extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $tags=db('tag')->paginate(5);
        $this->assign('tags',$tags);
        return $this->fetch();
    }
    public function store()
    {
        if (\request()->isPost())
        {
            //halt(input('post.'));
            $res=(new \app\blog_admin\model\Tag())->store(input('post.'));
            if ($res['valid'])
            {
                $this->success($res['msg'],'index');
            }
            else{
                $this->error($res['msg']);
            }
        }

        return $this->fetch();
    }
       public function edit()
    {
        if (\request()->isPost())
        {
            $res=(new \app\blog_admin\model\Tag())->edit(input('post.'));
            if ($res['valid'])
            {
                $this->success($res['msg'],'index');
            }
            else{
                $this->error($res['msg']);
            }
        }
        $oldData=\app\blog_admin\model\Tag::find(input('param.tag_id'));
        //halt($oldData);
        $this->assign('oldData',$oldData);
        return $this->fetch();
    }

    /*
     * 删除
     */
    public function del()
    {
        $tag_id=input('get.');
        $res= db('tag')->delete($tag_id);
        if ($res)
        {
            $this->success('删除成功','index');
        }
        else{
            $this->error('删除失败');
        }
    }


}
