<?php


/*
 * @Descripttion: Home控制器
 * @Author: tacks321@qq.com
 * @Date: 2021-08-27 16:28:56
 * @LastEditTime: 2021-08-27 17:20:48
 */

class HomeController extends BaseController 
{

    public function index()
    {
        $title = "<h1> 控制器、方法  Home/index </h1>";


        $list  = Article::getAll();
        $count = count($list);

        require dirname(__FILE__).'/../views/index.php';
        
    }

}