<?php
namespace core\lib;

use core\lib\Config;

class Log
{
    //日志对象
    public static $logobj;

    /*
    *功能:读取配置文件确定存放方式，生成日志对象
    **/
    public static function init()
    {
        //1.加载日志写入位置选项
        $drive = Config::get('DRIVE', 'log');
        //2.引入对应的类
        $drive = ucfirst($drive);
        $class = '\core\lib\drive\log\\' . $drive;
        self::$logobj = new $class();
    }

    /*
    *写入log文件中
    *@param string 日志信息
    */
    public static function log($mes)
    {
        self::init();
        self::$logobj->log($mes);
    }
}