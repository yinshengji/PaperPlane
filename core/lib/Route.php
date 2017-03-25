<?php
/**
 * Created by PhpStorm.
 * User: yinshengji
 * Date: 2016/9/2 0002
 * Time: 下午 7:26
 */
namespace core\lib;

use core\lib\Config;

class Route
{

    public $module;
    public $cntl;
    public $action;

    public function __construct()
    {
        //xxx.com/index/index/index
        /*
         * 1.隐藏掉index.php（.htaccess/nginx配置后）
         * 2.获取url参数[$_server['REQUEST_URI']]
         * 3.返回对象的控制器和方法
         */
        if ($_SERVER['REQUEST_URI'] != '/' && isset($_SERVER['REQUEST_URI'])) {
            // /index/index/index的解析
            $request = $_SERVER['REQUEST_URI'];
            $reqArray = explode('/', ltrim($request, '/'));


            if (isset($reqArray[0])) {
                $this->module = $reqArray[0];
                unset($reqArray[0]);
            }

            if (isset($reqArray[1])) {
                $this->cntl = $reqArray[1];
                unset($reqArray[1]);
            } else {
                $this->cntl = Config::get('CNTL', 'route');
            }

            if (isset($reqArray[2])) {
                $this->action = $reqArray[2];
                unset($reqArray[2]);
            } else {
                $this->action = Config::get('ACTION', 'route');
            }

            if (!empty($reqArray)) {
                //将剩下的值作为get的请求参数
                $countParam = count($reqArray);
                if ($countParam % 2 != 0) {
                    E('param error');
                }

                for ($i = 3; $i < $countParam + 3; $i += 2) {
                    $_GET[$reqArray[$i]] = $reqArray[$i + 1];
                }
            }


        } else {
            //不存在就默认是index的index方法]
            $this->module = Config::get('MODULE', 'route');
            $this->cntl = Config::get('CNTL', 'route');
            $this->action = Config::get('ACTION', 'route');
        }
    }
}