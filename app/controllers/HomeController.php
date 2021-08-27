<?php


/*
 * @Descripttion: Home控制器
 * @Author: tacks321@qq.com
 * @Date: 2021-08-27 16:28:56
 * @LastEditTime: 2021-08-27 17:12:38
 */

class HomeController extends BaseController 
{

    public function index()
    {
        echo "<h1> 控制器、方法  Home/index </h1>";

        echo "<hr>读取数据<br>";

        $list = Article::getAll();

        echo count($list);

        
    }

}