<?php
/*
 * @Descripttion: 视图类
 * @Author: tacks321@qq.com
 * @Date: 2021-08-28 16:18:19
 * @LastEditTime: 2021-08-30 14:39:44
 */

class View
{
    // 视图目录
    const VIEW_BASE_PATH = 'app/views/';

    public $view;
    public $data;

    public function __construct($view)
    {
        // 接受视图名称作为参数，以  .  作为目录的间隔符
        $this->view = $view;
    }

    public static function make($viewName = null)
    {
        if (!$viewName) {
            // 验证输入数据 如果将错误或空的参数 InvalidArgumentException
            throw new InvalidArgumentException("视图名称不能为空！");
        } else {
            // 获取文件名
            $viewFilePath = self::getFilePath($viewName);
            if (is_file($viewFilePath)) {
                return new View($viewFilePath);
            } else {
                // 验证时，如果有异常或不匹配的地方 UnexpectedValueException
                throw new UnexpectedValueException("视图文件不存在！");
            }
        }
    }


    // 变量装载到视图中
    public function with($key, $value = null)
    {
        $this->data[$key] = $value;
        return $this;
    }


    /**
     * 获取文件名
     *
     * @param string $viewName 视图文件名
     * @return string
     */
    private static function getFilePath($viewName)
    {
        // 把. 替换成 /
        $filePath = str_replace('.', '/', $viewName);
        return BASE_PATH . DIRECTORY_SEPARATOR . self::VIEW_BASE_PATH . $filePath . '.php';
    }



    /**
     * 变量装载到视图
     *
     * @param string $method
     * @param mixed $parameters
     */
    public function __call($method, $parameters)
    {
        // 如果方法名以 with开头
        if(strpos($method, 'with') === 0 ){
            return $this->with(self::snake_case(substr($method, 4)), $parameters[0]);
        }
  
        throw new BadMethodCallException("方法 [$method] 不存在！.");
    }


    /**
     * 大驼峰转化为下划线
     *
     * @param  string $str
     * @return string 
     */
    private static function snake_case($str)
    {
        $dstr = preg_replace_callback('/([A-Z]+)/',function($matchs)
            {
                return '_'.strtolower($matchs[0]);
            },$str);
    
        return trim(preg_replace('/_{2,}/','_',$dstr),'_');
    }



}
