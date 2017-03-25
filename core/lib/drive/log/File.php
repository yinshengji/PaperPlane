<?php
namespace core\lib\drive\log;

/* 
*功能:将日志写入到文件中
*/
class File
{
    //生成的日志文件名称
    public static $filename;

    /*
    *功能：初始化日志系统
    *1.日志文件夹检测(若无则创建)
    *2.生成文件名
    */
    public static function init()
    {
        $dir = TC . '/log';
        if (!is_dir($dir)) {
            try {
                mkdir($dir, '777', true);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
        self::filename();
        if (!file_exists(self::$filename)) {
            try {
                touch(self::$filename);
            } catch (\Exception $e) {
                echo '文件夹创建失败';
                return false;
            }
        }
    }

    /*
    *生成文件名
    */
    public static function filename()
    {
        self::$filename = TC . '/log/log' . date("Ymd");
    }

    /*
    *写日志文件
    *@param string $mes 日志信息
    */
    public static function log($mes)
    {
        //1.初始化日志系统
        self::init();
        //2.格式化日志内容
        $mes = '[' . date("H:i:s") . ']' . $mes . PHP_EOL;
        try {
            file_put_contents(self::$filename, $mes, FILE_APPEND);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}