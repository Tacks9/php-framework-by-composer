<?php
/*
 * @Descripttion: 入口文件
 * @Date: 2021-08-27 11:38:12
 * @LastEditTime: 2021-08-27 16:31:39
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

function dd($var)
{

    echo '<br>';
    var_dump($var);
    echo '</br>';

    $array = debug_backtrace();
    foreach ($array as $row) {
        printf("文件名：%s  |  行数：%s  | 方法：%s  \r\n<br/>", $row['file'],  $row['line'], $row['function']);
    }
   
}


// Composer Autoload 自动载入
require '../vendor/autoload.php';

/**
 * 
 * Composer 的自动加载在每次 URL 驱动 public/index.php 之后会在内存中维护一个全量命名空间类名到文件名的数组
 * 
 * 这样当我们在代码中使用某个类的时候，将自动载入该类所在的文件。
 * 
 */

// 路由配置载入
require '../config/routes.php';
