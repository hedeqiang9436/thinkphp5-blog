<?php
namespace app\blog_admin\validate;
use think\Validate;

class Article extends Validate
{
    protected $rule=[
        'art_title'=>'require',
        'art_author'=>'require',
        'art_remark'=>'require',
        'art_content'=>'require',
        'art_sort'=>'require|number',
        'cate_id'=>'notIn:0',
        'art_thumb'=>'require',
    ];

    protected $message=[
        'art_title.require'=>'请输入文章标题',
        'art_author.require'=>'请输入作者',
        'art_remark.require'=>'请输入文章摘要',
        'art_content.require'=>'请输入文章内容',
        'art_sort.require'=>'请输入文章排序',
        'art_sort.number'=>'排序必须为数字',
        'cate_id.notIn'=>'请选择分类',
        'art_thumb'=>'请上传图片',
    ];
}