<?php

namespace app\blog_admin\controller;

use think\Controller;
use think\Request;

class Article extends Controller
{
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        $articles=db('article')->alias('art')
            ->join('_category_ cat ','art.cate_id=cat.cate_id')
            ->paginate(5);
       $this->assign('articles',$articles);
        return $this->fetch();
    }

    /*
     * 添加
     */
    public function store()
    {
        if (\request()->isPost())
        {
            //halt(input('post.'));
            $res=(new \app\blog_admin\model\Article())->store(input('post.'));
            if ($res['valid'])
            {
                $this->success($res['msg'],'index');
            }
            else{
                $this->error($res['msg']);
            }
        }
        //获取分类信息
        $cateData=(new \app\blog_admin\model\Category())->cate_list();
        //halt($cateData);
        $this->assign('cateData',$cateData);
        //获取标签信息
        $tagData=db('tag')->select();
        // halt($tagData);
        $this->assign('tagData',$tagData);
        return $this->fetch();
    }
    /*
     * 编辑
     */
    public function edit()
    {
        //获取分类信息
        $cateData=(new \app\blog_admin\model\Category())->cate_list();
        //halt($cateData);
        $this->assign('cateData',$cateData);
        //获取标签信息
        $tagData=db('tag')->select();
        // halt($tagData);
        $this->assign('tagData',$tagData);
        return $this->fetch();
    }
    /*
     * 上传
     */
    public function upload(){
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('file');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->validate(['ext'=>'jpg,png,gif'])->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            // 输出 jpg
            //echo $info->getExtension();
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
            echo $info->getSaveName();
            // 输出 42a79759f284b767dfcb2a0197904287.jpg
            //echo $info->getFilename();
        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }
    }

}
