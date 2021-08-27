<?php

namespace NoahBuscher\Macaw;

/**
 * @method static Macaw get(string $route, Callable $callback)
 * @method static Macaw post(string $route, Callable $callback)
 * @method static Macaw put(string $route, Callable $callback)
 * @method static Macaw delete(string $route, Callable $callback)
 * @method static Macaw options(string $route, Callable $callback)
 * @method static Macaw head(string $route, Callable $callback)
 */
class Macaw {
  public static $halts = false;       // 停顿
  public static $routes = array();    // 路由
  public static $methods = array();   // 方法
  public static $callbacks = array(); // 回调
  public static $maps = array();      // map

  // 正侧匹配规则
  public static $patterns = array(
      ':any' => '[^/]+',
      ':num' => '[0-9]+',
      ':all' => '.*'
  );

  // 错误的回调
  public static $error_callback;

  /**
   * Defines a route w/ callback and method
   * 
   * @param mixed $method 方法名
   * @param mixed $params 参数
   * 
   * __callstatic 会在调用类的一个不存在的静态方法 ( 不存在或该方法不可访问 ) 时自动调用，作用和原型都类似于 __call()
   * 
   */
  public static function __callstatic($method, $params) {

    // 判断是否是 map 方法调用
    if ($method == 'map') {
        $maps = array_map('strtoupper', $params[0]);
        $uri  = strpos($params[1], '/') === 0 ? $params[1] : '/' . $params[1];
        $callback = $params[2];
    } else {
        $maps = null;

        // $params[0] 路由path    ====> $uri (默认补充根斜线 / )
        // $params[1] 回调函数    ====> $callback

        $uri = strpos($params[0], '/') === 0 ? $params[0] : '/' . $params[0];
        $callback = $params[1];
    }

    // 加入系统静态变量
    array_push(self::$maps, $maps);                   // 调用是否map处理
    array_push(self::$routes, $uri);                  // 配置的路由path
    array_push(self::$methods, strtoupper($method));  // 调用方法都大写处理
    array_push(self::$callbacks, $callback);          // 回调函数
  }

  /**
   * Defines callback if route is not found
  */
  public static function error($callback) {
    self::$error_callback = $callback;
  }

  public static function haltOnMatch($flag = true) {
    self::$halts = $flag;
  }

  /**
   * Runs the callback for the given request
   * 
   * 
   * $_SERVER['REQUEST_URI']    访问此页面所需的URI
   * $_SERVER['REQUEST_METHOD'] 页面访问方式
   * 
   */
  public static function dispatch(){
    // 获取当前页面的 Path
    $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

    // 获取当前页面请求方式 method
    $method = $_SERVER['REQUEST_METHOD'];

    // 获取所有正侧要匹配的方式
    $searches = array_keys(static::$patterns);
    $replaces = array_values(static::$patterns);

    // 是否找到对应的路由
    $found_route = false;

    // 路由配置的时候 将两个斜杠都进行转为一个斜杠
    self::$routes = preg_replace('/\/+/', '/', self::$routes);

    // 当前页面，有无符合配置的路由
    // Check if route is defined without regex
    if (in_array($uri, self::$routes)) {
      // 找寻一下，当前配置的routes中，有没有对应的 path
      $route_pos = array_keys(self::$routes, $uri);
      

      // 比如可能有两个 get和post的请求方式
      foreach ($route_pos as $route) {

        // 然后进行比对方法 method
        // ① 当前方法，整好对应路由方法
        // ② 路由方法，采用的是ANY 任意

        // Using an ANY option to match both GET and POST requests
        if (self::$methods[$route] == $method || self::$methods[$route] == 'ANY' || (!empty(self::$maps[$route]) && in_array($method, self::$maps[$route]))) {

          // 找到路由
          $found_route = true;

          // 如果路由不是对象
          // If route is not an object
          if (!is_object(self::$callbacks[$route])) {


            // 以/进行分类 获取各个部分（例如：Macaw::get('page', 'Controllers\demo@page'); ）
            // Grab all parts based on a / separator
            $parts = explode('/',self::$callbacks[$route]);

            // Collect the last index of the array
            $last = end($parts);


            // 获取真正要调用的方法函数
            // Grab the controller name and method call
            $segments = explode('@',$last);


            // 初始化控制器
            // Instanitate controller
            $controller = new $segments[0]();

            // 回调方法
            // Call method
            $controller->{$segments[1]}();

            // 判断是否暂定
            if (self::$halts) return;


          } else {
            // 如果回调是方法
            // Call closure
            call_user_func(self::$callbacks[$route]);

            // 判断是否暂停
            if (self::$halts) return;
          }
        }



      }
    } else {

      // 正则进行路由匹配

      // Check if defined with regex
      $pos = 0;
      foreach (self::$routes as $route) {
        if (strpos($route, ':') !== false) {
          $route = str_replace($searches, $replaces, $route);
        }

        if (preg_match('#^' . $route . '$#', $uri, $matched)) {
          if (self::$methods[$pos] == $method || self::$methods[$pos] == 'ANY' || (!empty(self::$maps[$pos]) && in_array($method, self::$maps[$pos]))) {
            $found_route = true;

            // Remove $matched[0] as [1] is the first parameter.
            array_shift($matched);

            if (!is_object(self::$callbacks[$pos])) {

              // Grab all parts based on a / separator
              $parts = explode('/',self::$callbacks[$pos]);

              // Collect the last index of the array
              $last = end($parts);

              // Grab the controller name and method call
              $segments = explode('@',$last);

              // Instanitate controller
              $controller = new $segments[0]();

              // Fix multi parameters
              if (!method_exists($controller, $segments[1])) {
                echo "controller and action not found";
              } else {
                call_user_func_array(array($controller, $segments[1]), $matched);
              }

              if (self::$halts) return;
            } else {
              call_user_func_array(self::$callbacks[$pos], $matched);

              if (self::$halts) return;
            }
          }
        }
        $pos++;
      }
    }

    // 如果找不到路由 就走最后的报错信息
    // Run the error callback if the route was not found
    if ($found_route == false) {
      if (!self::$error_callback) {
        self::$error_callback = function() {
          header($_SERVER['SERVER_PROTOCOL']." 404 Not Found");
          echo '404';
        };
      } else {
        if (is_string(self::$error_callback)) {
          self::get($_SERVER['REQUEST_URI'], self::$error_callback);
          self::$error_callback = null;
          self::dispatch();
          return ;
        }
      }
      call_user_func(self::$error_callback);
    }
  }


}
