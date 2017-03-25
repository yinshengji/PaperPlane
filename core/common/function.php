<?php
/**
 * 功能:打印数据
 * @param mixed $var
 */
function P($var)
{
    //调用美化的dump
    dump($var);
}

/*
*功能：输出警告信息到日志文件
*@param string $mes 输出的警告信息
*return null
*/
function E($mes)
{
    if (DEBUG === true) {
        P($mes);
    }
    \core\lib\Log::log($mes);
    return;
}
