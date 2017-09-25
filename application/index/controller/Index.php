<?php
namespace app\index\controller;

use function MongoDB\BSON\toJSON;
use think\Controller;
use Overtrue\Pinyin\Pinyin;
class Index extends Controller
{
    public function index()
    {
        $pinyin=new Pinyin();
        //$pinyin->convert('带着希望去旅行，比到达终点更美好');
        //echo $pinyin->sentence('带着希望去旅行，比到达终点更美好！', true);
        //$arr_name= $pinyin->name('贺德强', PINYIN_UNICODE); // ["shàn","mǒu","mǒu"]
       // echo implode(' ',$arr_name);

        $tags=db('tag')->select();
        $this->assign('tags',$tags);
        $articles=db('article')->alias('art')
            ->join('_category_ cat ','art.cate_id=cat.cate_id')
            ->paginate(10);
        $this->assign('articles',$articles);
        return $this->fetch();
    }
    public function article()
    {
        $tags=db('tag')->select();
        $this->assign('tags',$tags);

        $art_id=input('param.art_id');
        //halt($art_id);
        $article=db('article')->alias('art')
            ->join('_category_ cat ','art.cate_id=cat.cate_id')
            ->where('art.art_id',$art_id)
            ->find();
        $this->assign('article',$article);
        return $this->fetch();
    }
}
