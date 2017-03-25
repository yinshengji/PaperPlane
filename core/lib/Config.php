<?php
namespace core\lib;

class Config
{
    public static $conf = array();

    /*
    *功能获取配置项信息
    *@param string $name 配置项名称
    *@param string $file 配置项文件名
    *return mixed {配置项信息|异常|}
    */
    public static function get($name, $file)
    {
        /**
         *1.判断配置文件是否存在
         *2.判断配置项是否存在
         *3.缓存配置
         */
        //0.先从缓存中检查是否有
        if (isset(self::$conf[$file][$name])) {
            return self::$conf[$file][$name];
        }
        //1.加载配置文件
        $path = TC . '/core/config/' . $file . '.php';
        try {
            if (is_file($path)) {
                $conf = include $path;
                //2.检查配置项是否存在
                if (isset($conf[$name])) {
                    //3.缓存配置
                    self::$conf[$file] = $conf[$name];
                    return $conf[$name];
                } else {
                    throw new \Exception('配置项' . $name . '不存在');
                }
            } else {
                throw new \Exception('配置文件' . $file . '不存在');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public static function all($file)
    {
        /**
         *1.判断配置文件是否存在
         *2.缓存配置
         */
        //0.先从缓存中检查是否有该配置文件的数组
        if (isset(self::$conf[$file])) {
            return self::$conf[$file];
        }
        //1.加载配置文件
        $path = TC . '/core/config/' . $file . '.php';
        try {
            if (is_file($path)) {
                $conf = include $path;
                //2.缓存配置
                self::$conf[$file] = $conf;
                return $conf;
            } else {
                throw new \Exception('配置文件' . $file . '不存在');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}