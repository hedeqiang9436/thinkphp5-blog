<?php

namespace app\blog_admin\controller;

use think\Controller;
use think\Request;

class Comm extends Controller
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        if (!session('user_id'))
        {
            $this->redirect('blog_admin/login/login');
        }
    }
}
