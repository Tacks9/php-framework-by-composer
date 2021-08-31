<?php


/*
 * @Descripttion: Home控制器
 * @Author: tacks321@qq.com
 * @Date: 2021-08-27 16:28:56
 * @LastEditTime: 2021-08-31 10:23:27
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

    public function recentList()
    {
        $title = "<h1> 控制器、方法  Home/recentList </h1>";


        $list  = Article::getList();
        $count = count($list);

        require dirname(__FILE__).'/../views/index.php';
        
    }

    // 文章数据
    public function article()
    {
        $page_title = "控制器、方法  Home/article ";


        $article  = Article::getArticle();


        // 直接调用赋值视图
        $this->view = View::make('home.article')->with('article',$article)
                                                ->withPageTitle($page_title);

        
    }


     // 邮件发送
    public function mailsend()
    {
        $page_title = "控制器、方法  Home/mailsend ";

        $article  = Article::getArticle();

        $msg = sprintf("<h1>【PFC 邮件发送测试】<h1/> <hr/> 文章标题：%s <br/> 文章链接：%s <br/>", $article['title'], $article['link']);


        // 设置邮件发送信息
        $this->mail = Mail::to(['tacks15188216107@163.com'])
                                    ->from('Tacks <tacks321@qq.com>')
                                    ->title($page_title)
                                    ->content($msg);


        // 直接调用赋值视图
        $this->view = View::make('home.article')->with('article',$article)
                                                ->withPageTitle($page_title);

        
    }

}