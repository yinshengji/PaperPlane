<?php
/**
 * Created by PhpStorm.
 * User: ysj
 * Date: 2016/9/2 0002
 * Time: 下午 6:30
 */
namespace core;

class Framework
{
    //将引入的文件存放到这个类映射数组中
    public static $classMap = [];

    /**
     *
     * 功能:初始化框架(加载路由和控制类)
     */
    public static function run()
    {
        //引入vendor
        include TC . '/vendor/autoload.php';

        //debug设置
        if (DEBUG == true) {
            //调用filp错误追踪
            $whoops = new \Whoops\Run;
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
            $whoops->register();
            //ini_set('display_error','on');
        } else {
            ini_set('displsy_error', 'off');
        }

        //引入框架的函数库
        include CORE . '/common/function.php';

        // 设置自动加载类
        spl_autoload_register(['\core\Framework', 'load'], false, false);

        /* 设置时区 */
        date_default_timezone_set("PRC");

        /* 加载路由类获取控制器和方法 */
        $route = new \core\lib\Route();
        $module = $route->module;
        $controller = ucfirst($route->controller . 'Controller');
        $action = $route->action;

        $cntlFile = APP . $module . '/controller/' . $controller . '.php';
        $cntlClass = '\\' . APP_NAME . '\\' . $module . '\controller\\' . $controller;

        if (file_exists($cntlFile)) {

            if (class_exists($cntlClass)) {
                $cntlobj = new $cntlClass();
                $cntlClass::$module = $route->module;
                $cntlClass::$controller = $controller;
            } else {
                $error_string = 'class ' . $cntlClass . ' not exist, spelling error or namespace missing ?';
                E($error_string);
                return false;
            }

            if (method_exists($cntlobj, $action)) {
                $cntlClass::$action = $route->action;
                //$cntlobj->$action();
                call_user_func_array([$cntlobj, $action], $_REQUEST);
            } else {
                $error_string = 'function ' . $action . ' not find in' . $cntlClass;
                E($error_string);
                return false;
            }
        } else {
            $error_string = 'file ' . $cntlFile . ' not exist';
            E($error_string);
        }
        return true;
    }

    /*
    * 功能：自动加载类的callback函数
    * @param string 类名
    * return bool
    */
    public static function load($class)
    {
        //1.检测类是否已经引入
        if (isset(self::$classMap[$class])) {
            return true;
        } else {
            //2.include未加载的类
            //$class是namespace   core\lib\route格式 -> core/lib/route
            $class_temp = str_replace('\\', '/', $class);
            $file = TC . '/' . $class_temp . '.php';

            if (file_exists($file)) {
                include $file;
                self::$classMap[$class] = true;
            } else {
                return false;
            }
        }

    }

}
