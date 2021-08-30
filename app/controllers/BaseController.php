<?php
/*
 * @Descripttion: 控制器基类
 * @Author: tacks321@qq.com
 * @Date: 2021-08-27 16:27:36
 * @LastEditTime: 2021-08-30 14:41:49
 */


class BaseController 
{
    // 视图
    protected $view;


    public function __construct()
    {
        
    }

    public function __destruct()
    {

        $view = $this->view;

        // 单例模式
        if ( $view instanceof View ) {

            // 从数组中将变量导入到当前的符号表
            extract($view->data);

            require $view->view;

        }

    }

}