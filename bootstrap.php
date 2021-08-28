<?php

/*
 * @Descripttion: 视图装载启动器
 * @Author: tacks321@qq.com
 * @Date: 2021-08-28 16:11:30
 * @LastEditTime: 2021-08-28 16:37:24
 */

// 做一系列准备工作

// 定义 BASE_PATH
define('BASE_PATH', __DIR__);


/**
 * 
 * Composer 的自动加载在每次 URL 驱动 public/index.php 之后会在内存中维护一个全量命名空间类名到文件名的数组
 * 
 * 这样当我们在代码中使用某个类的时候，将自动载入该类所在的文件。
 * 
 */

// Autoload 自动载入
require BASE_PATH.'/vendor/autoload.php';