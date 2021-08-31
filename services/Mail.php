<?php
/*
 * @Descripttion: 邮件类
 * @Author: tacks321@qq.com
 * @Date: 2021-08-30 20:36:22
 * @LastEditTime: 2021-08-31 10:22:22
 */

use Nette\Mail\Message;

class Mail extends Message
{

    // 邮件配置信息
    public $config;

    // 邮件发送者
    protected $from;

    // 邮件接收者（支持list/string）
    protected $to;

    // 邮件标题
    protected $title;

    // 邮件内容
    protected $body;
    

    function __construct($to)
    {
        $this->config = require BASE_PATH.'/config/mail.php';

        $this->setFrom($this->config['username']);

        if(is_array($to)) {
            foreach($to as $email) {
                $this->addTo($email);
            }
        } else {
            $this->addTo($to);
        }

        
    }

    /**
     * 设置发件人
     *
     * @param string $from
     */
    public function from($from = null) 
    {
        if(!$from) {
            throw new InvalidArgumentException("邮件发送地址不能为空！");
        }
        $this->setFrom($from);
        return $this;
    }

    /**
     * 设置收件人
     *
     * @param string|array $to
     */
    public static function to($to = null) 
    {
        if(!$to) {
            throw new InvalidArgumentException("邮件接收地址不能为空！");
        }
        return new Mail($to);
    }

    
    /**
     * 设置邮件标题
     *
     * @param string $title
     */
    public function title($title = null)
    {
        if(!$title) {
            throw new InvalidArgumentException("邮件标题不能为空！");
        }
        $this->setSubject($title);
        return $this;
    }

    /**
     * 设置邮件内容
     *
     * @param string $content
     */
    public function content($content = null) 
    {
        if(!$content) {
            throw new InvalidArgumentException("邮件内容不能为空！");
        }
        $this->setHTMLBody($content);
        return $this;
    }

    

}