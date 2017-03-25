<?php
/**
 * 描述：入口文件
 * 1.定义常量
 * 2.加载函数库
 * 3.启动框架
 * User: yinshengji
 */
/*设置根目录的全局常量*/
define('TC', str_replace('\\', '/', realpath('./')));
/*设置框架核心目录的全局常量*/
define('CORE', TC . "/core/");
/*设置项目目录全局常量*/
define('APP', TC . "/app/");
/*设置网站目录的全局常量*/
define('APP_NAME', 'app');

/*设置debug情况*/
define('DEBUG', true);

/*引入框架的初始化文件*/
include CORE . "Framework.php";

/*启动框架*/
\core\Framework::run();
