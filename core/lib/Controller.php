<?php

namespace core\lib;

class Controller
{
    public static $module;
    public static $controller;
    public static $action;
    //存储assign文件
    public $assign = array();

    /**
     *功能：将变量赋值到模板
     * @param string $name 属性名
     * @param mixed $value 属性值
     */
    public function assign($name, $value)
    {

        $this->assign[$name] = $value;
    }

    /**
     *功能：加载视图文件
     * @param str $view视图名
     */
    public function display($view)
    {
        $suffix = Config::get('suffix', 'view');
        $file = APP . self::$module . '/view/' . $view . '.' . $suffix;
        if (file_exists($file)) {
            extract($this->assign);
            include "$file";
        } else {
            E('file ' . $file . ' not found');
        }
        return;
    }
}