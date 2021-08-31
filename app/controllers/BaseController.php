<?php
/*
 * @Descripttion: 控制器基类
 * @Author: tacks321@qq.com
 * @Date: 2021-08-27 16:27:36
 * @LastEditTime: 2021-08-31 10:12:39
 */


class BaseController 
{
    // 视图
    protected $view;

    // 邮件
    protected $mail;


    public function __construct()
    {
        
    }

    public function __destruct()
    {

        // ====================== 视图服务

        $view = $this->view;

        // 单例模式
        if ( $view instanceof View ) {

            // 从数组中将变量导入到当前的符号表
            extract($view->data);

            require $view->view;

        }

        // ====================== 邮件服务

        $mail = $this->mail;

        if ( $mail instanceof Mail ) {
      
            // 实例化邮件发送服务
            $mailer = new Nette\Mail\SmtpMailer($mail->config);
        
            $mailer->send($mail);
      
        }
        
    }

}