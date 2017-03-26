<?php
/**
 * Created by PhpStorm.
 * User: ysj
 * Date: 2016/9/6 0002
 * Time: 下午 11:06
 */

namespace app\index\controller;
use app\index\Model\UserModel;
use core\lib\Controller;

class TestController extends Controller
{
    public function index(){
        $testModel = new UserModel();
        $testModel->test();
    }

    public function showview(){
        $data = 'hello';
        $this->assign('data',$data);
        $this->display('test/index.html');
    }

    public function test()
    {
        $res = \core\lib\Config::all('db');
        $res = \core\lib\Config::all('db');
        $res = \core\lib\Config::getByDot('default.USERNAME', 'db');
        var_dump($res);
        var_dump($_POST);
        var_dump($_GET);
    }

}
