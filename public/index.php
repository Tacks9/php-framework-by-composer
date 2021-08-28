<?php
/*
 * @Descripttion: 入口文件
 * @Date: 2021-08-27 11:38:12
 * @LastEditTime: 2021-08-28 16:42:02
 */
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);


// 【常量定义】
define('PUBLIC_PATH', __DIR__);

 
// 【启动器】
require PUBLIC_PATH .'/../bootstrap.php';


// 路由配置载入
require '../config/routes.php';
