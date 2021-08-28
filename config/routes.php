<?php
/*
 * @Descripttion: 路由文件
 * @Date: 2021-08-27 11:38:12
 * @LastEditTime: 2021-08-28 11:37:27
 */

// 路由文件中载入了 Macaw 类：“use NoahBuscher\Macaw\Macaw;”

use NoahBuscher\Macaw\Macaw;


// 接着调用了两次静态方法  Macaw::get($URL, $FUNCTION)
// 这个方法是不存在的，将由 /vendor/codingbean/macaw/Macaw.php 中的 __callstatic() 接管
// 第一个参数是我们想要监听的 URL 值，第二个参数是一个 PHP 闭包，作为回调，代表 URL 匹配成功后我们想要做的事情。


// 配置路由
Macaw::get('//', function() {
    echo 'GET:Hello world!';
});

Macaw::get('/home', 'HomeController@index');


// 获取最新5条数据
Macaw::get('/home/recentList', 'HomeController@recentList');



// 配置404路由
Macaw::get('(:all)', function($fu) {
  echo '未匹配到路由 404 <br/>'.$fu;
});
  



// 真正调用

// 派遣调度所配置的路由
Macaw::dispatch();