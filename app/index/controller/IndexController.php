<?php

namespace app\index\controller;

use app\index\model\UserModel;
use core\lib\Controller;

class IndexController extends Controller
{
    public function index()
    {
        echo 'this is index page';
        return;
        $model = new UserModel();
        $model->test();
    }

    public function show()
    {
        $str = 'teststr';
        $this->assign('str', $str);
        $this->display('index/show');
        $this->assign('str', '123');
        $this->display('index/show');
    }
}