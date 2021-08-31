# PHP-FRAMEWORK-BY-COMPOSER

> 玩一下`composer`搭建框架的流程


## 0 学习资料

- [利用 Composer 一步一步构建自己的 PHP 框架（一）——基础准备](http://lvwenhan.com/php/405.html)
- [利用 Composer 一步一步构建自己的 PHP 框架（二）——构建路由](http://lvwenhan.com/php/406.html)
- [利用 Composer 一步一步构建自己的 PHP 框架（三）——设计 MVC](https://lvwenhan.com/php/408.html)
- [利用 Composer 一步一步构建自己的 PHP 框架（四）——使用 ORM](http://lvwenhan.com/php/409.html)
- [利用 Composer 完善自己的 PHP 框架（一）——视图装载](https://lvwenhan.com/php/410.html)
- [利用 Composer 完善自己的 PHP 框架（二）——发送邮件](https://lvwenhan.com/php/412.html)
- [利用 Composer 完善自己的 PHP 框架（三）——Redis 缓存](https://lvwenhan.com/php/413.html)


## 1 Composer依赖管理器

> 默认在项目的`vendor`目录进行安装，相关的依赖库。

### 1.1 下载安装

```shell
# php73是我的php命令环境，这个根据具体的情况使用
$ php73 -r "copy('https://install.phpcomposer.com/installer', 'composer-setup.php');"
$ php73 composer-setup.php
$ php73 -r "unlink('composer-setup.php');"

# 然后会生成一个命令文件 `composer.phar`

# 例如安装库
$ php73 composer.phar require gregwar/captcha
```


### 1.2 可以使用的镜像

```shell
$ php73 composer.phar config -g repo.packagist composer https://packagist.phpcomposer.com
$ php73 composer.phar config -g repo.packagist composer https://mirrors.aliyun.com/composer/  --no-plugins
$ php73 composer.phar config -g repo.packagist composer https://mirrors.cloud.tencent.com/composer/
```

### 1.3 配置文件

- `composer.json`

```json
{
    "require": {
    }
}
```

### 1.4 `composer`初始化目录

```shell
$ php73 composer.phar update
```

## 2 PHP框架基础

### 2.1 路由

#### 初始步骤


- [GitHub上高分的PHP路由插件](https://github.com/search?l=PHP&o=desc&q=router&ref=searchresults&s=stars&type=Repositories&utf8=%E2%9C%93)
- [noahbuscher/macaw](https://github.com/noahbuscher/macaw)

- 安装

```json
# 安装路由库
{
  "require": {
    "noahbuscher/macaw": "dev-master"
  }
}
# 更新
$ php73 composer.phar update
```

- 引入

```php
// composer 自动加载
use \NoahBuscher\Macaw\Macaw;

// 路由配置
Macaw::get('/', function() {
  echo 'Hello world!';
});

Macaw::dispatch();
```





#### 【noahbuscher/macaw】

> 主要根据一个静态类(`Macaw`)来进行实现，是一个简单的PHP路由器，只需要通过composer，引入文件，就能快速使用。

**主要技术点**

- `static` 静态类、静态成员变量、静态方法（因此不需要new对象，而是可以直接通过类进行调用）
- `__callstatic` 魔术方法，用来调用不存在的类的静态方法（这样好处是同上，想要静态化去做）
- `$_SERVER` 服务器环境信息的数组 （需要去拿到相关当前页面路径的信息）
  - `$_SERVER['REQUEST_METHOD']` 访问页面请求的方法（如，GET、POST）
  - `$_SERVER['REQUEST_URI']`    访问页面所需的URI （如，/index.html）
- 一些基础的PHP函数
  - 页面url
    - `parse_url()` 用来获取页面url的path部分内容 （如，用来寻找当前页面的path）
  - 正册相关
    - `preg_match()`   执行匹配正则表达式
    - `preg_replace()` 正则替换 (如，用于批量将//转化为/)
  - 数组相关
    - `array_keys()` 用来获取数组的key的部分，返回数组
    - `array_values()`用来获取数组的value的部分，返回数组
  - 字符串相关
    - `strpos()`  用来寻找字符串首次出现的位置    （如，用来寻找路由 / 的位置）
    - `str_replace()`
  - 字符串数组转化相关
    - `explode()` 将字符串进行分割成数组，拿到不同的part （如，Controllers\demo@page）
  - 类型判断相关
    - `is_array()`
    - `is_object()`
    - `method_exists()`
  - 函数回调
    - `call_user_func()`

**主要流程**

1. 路由装载。通过静态方法的形式（`Macaw::get()`），将项目所有的路由配置都加载进去
  - 主要通过`__callstatic($method, $params)`方式来将不同的请求方式的路由配置读进去
  - 将相关路由信息push到静态数组中（① `uri` 、② `method` 、③ `callback`）
2. 路由调度。将当前页面的path与系统配置的路由对比，从而找到真正的执行方法
  - 获取当前页面请求的 uri
  - 获取当前页面请求的 method
  - found_route 用来标注是否匹配到路由 当前false
  - 看一下uri是否有完全匹配的路由
    - 有=> 进入完全匹配的形式
    - 无=> 进入正则匹配的形式
  - 假设进入完全匹配的形式
    - 获取全部匹配uri的路由，然后依次匹配对应method是否相等
    - method有完全匹配的，也有Any任意方式的都可以请求到
  - 假设进入完全匹配的形式，找到对应的方法的路由
    - 获取回调方式，可能是回调函数方法，可能是控制器调用的类的方法
    - 然后实现
  - 如果最后还是找不到
    - 404 显示 


### 2.2 控制器

#### 2.2.1 初始步骤

- `app/controllers` 控制器目录
- `BaseControllers` 基础控制器
- `HomeControllers` home控制器


```json
# composer配置自动加载
"autoload": {
    "classmap": [
      "app/controllers",
      "app/models"
    ]
}

# 更新
$ php73 composer.phar dump-autoload

# 文件变化

autoload_classmap.php文件   映射 classMap
  'BaseController' => $baseDir . '/app/controllers/BaseController.php',
  'HomeController' => $baseDir . '/app/controllers/HomeController.php',

autoload_static.php文件     映射 classMap
  'BaseController' => __DIR__ . '/../..' . '/app/controllers/BaseController.php',
  'HomeController' => __DIR__ . '/../..' . '/app/controllers/HomeController.php',

```


### 2.3 模型

#### 2.3.1 初始步骤

- `app/models` 模型目录
- `Article` article模型
- MySQL数据库链接方法
  - mysqli
  - pdo

- sql文件

[sql文件](./config/pfc.sql)

- json文件

```json
# composer配置自动加载
"autoload": {
    "classmap": [
      "app/models",
    ]
}

# 更新
$ php73 composer.phar dump-autoload

# 文件变化

autoload_classmap.php文件   映射 classMap
  'Article' => $baseDir . '/app/models/Article.php',

autoload_static.php文件     映射 classMap
  'Article' => __DIR__ . '/../..' . '/app/models/Article.php',

```

#### 2.3.2 `ORM`的选择

>  `ORM`全称是 `Object Relational Mapping` (对象关系映射) , O（Object）对象，数据Model持久化类。R（Relation）关系数据，M (Mapping)映射，将对象映射到关系数据，将关系数据映射到对象的过程。ORM 就是以OOP思想，产生增删改查SQL语句。 即用PHP来实现MySQL数据操作。比如有MySQL原生API、MySQLi面向过程、MySQLi面向对象、PDO等。


- [GitHub上高分的PHP数据库操作库](https://github.com/search?l=PHP&o=desc&p=1&q=pdo&s=stars&type=Repositories)
- [envms/fluentpdo](https://github.com/envms/fluentpdo/releases/tag/v2.2.2)
- [Getting Started with FluentPDO](https://www.sitepoint.com/getting-started-fluentpdo/)
- [中文文档](https://learnku.com/articles/20859)


**【`envms/fluentpdo`】**

- 安装

```shell
# 安装路由库
{
  "require": {
    	"envms/fluentpdo": "^2.2.0"
  }
}
# 更新
$ php73 composer.phar update

# 文件变化
### composer
autoload_psr4.php
  自动加载的映射      'Envms\\FluentPDO\\' => array($vendorDir . '/envms/fluentpdo/src'),
autoload_static.php
  prefixLengthsPsr4（长度映射关系，以第一个字母开头的数组，key为库，value为长度） 
  prefixDirsPsr4 （前缀路径对应，以库为key，路径映射为value）
installed.json
  envms/fluentpdo 库的信息 （一个大json）
installed.php
  每次root的reference都会变动一次
  增加库json基础简单信息
### fluentpdo
src主代码中
Queries/ 基本操作(Base、Common、Delete、Insert、Json、Select、Update)
Exception.php (异常处理)
Literal.php   (直译)
Query.php     (主文件)
Regex.php     (规则类)
Structure.php (结构主键、外键、索引)
Utilities.php (工具类)

```

- 使用

```php
$pdo    = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password, $options);
$fluent = new \Envms\FluentPDO\Query($pdo);

// 查询最新的5条数据
$query = $fluent->from('article')
                ->orderBy('id DESC')
                ->limit(5);

// 查询获取所有数据
$list = $query->fetchAll();
```
 

#### 2.3.3 数据库配置信息抽离

- 将数据库配置移到配置文件config中（database.php）




### 2.4 视图

#### 2.4.1 初始步骤

- `app/views` 视图目录
- 控制器获取模型数据，然后 `require` 控制器引入视图模板，渲染html

#### 2.4.2 视图作用

**功能**

- 可以根据视图名找到视图文件；
- 可以优雅的将变量的值传递给视图；

#### 2.4.3 视图装载类`View`自动加载操作

**`service/View.php` 视图装载器**


```php
# composer配置自动加载
"autoload": {
    "classmap": [
      "services",
    ]
}

# 更新
$ php73 composer.phar dump-autoload

# composer 文件变化

autoload_classmap.php文件   映射 classMap
  'View' => $baseDir . '/services/View.php',
autoload_static.php文件     映射 classMap
  'View' => __DIR__ . '/../..' . '/services/View.php',

```

#### 2.4.4 视图装载类`View`执行流程


1. `View`视图装载类
2. `View::make($viewName)`静态方法。接受视图名称作为参数，实例化`View`类的对象
    - `self::getFilePath($viewName)` 判断视图文件是否存在；
    - `Exception` 视图不存在则抛出异常；
    - `new View($viewFilePath)`如果试图存在，则返回视图对象；
3. `$this->with($key, $value = null)` 变量装载
    - 可以优雅的给这个 `View` 对象插入要在视图里调用的变量;
4. `$this->withKey($value)` 变量装载
    - 实现原理`__call($method, $parameters)` 魔术方法；
    - 例如 withPageTitle($value)将采用蛇形的命名，转化为 `$page_title`变量使用；
    - 例如 withTitle($value)将采用蛇形的命名，转化为 `$title`变量使用；
5. 控制器`Controller`中的视图变量 `$this->view` 则是基于 `BaseController`中
    - 父类`BaseController.php` 会在析构函数`__destruct()`中处理视图的加载；
    - `extract($data)` 变量加载。 视图要用到的变量;
    - `require($viewFilePath)`  视图文件。将最终运算结果发送给浏览器;




### 2.5 入口文件

#### 2.5.1 初始步骤 `index.php`

- 请求入口 `index.php`
  - 启动器`bootstrap.php` 
    - 自动加载 （引入autoload文件）
    - 初始化工作（例如数据库的一些配置等）
  - 加载路由 （最后加载路由去分发请求）

### 2.5 错误异常页面

#### 2.5.1 初始步骤

> 引用同laravel一样的错误信息提示，`filp/whoops`

- [filp/whoops](https://github.com/filp/whoops/tags)
  - 依赖于 [psr/log](https://github.com/php-fig/log)
- [文档](http://filp.github.io/whoops/)

**【filp/whoops】**

- 安装

```shell
# 安装路由库
{
  "require": {
      "filp/whoops": "*"
  }
}
# 更新
$ php73 composer.phar update
# 注意一下
vendor/composer下文件的变化

```

- 使用

```php
// 【启动器 bootstrap.php】
// 错误提示 whoops库引入  
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();

// 【路由 routes.php】
// 采用错误页面显示404
Macaw::$error_callback = function() {
    throw new Exception("路由无匹配项 404 Not Found");
};
```

- 测试  
 
- 访问到一个不存在的路由，观察页面报错内容，已经是同Larvel一样的报错信息


### 2.6 组件类库

`services` 目录

- `View.php` 视图装载器
- `Mail.php` 邮件发送器
- `Redis.php`Redis驱动类



### 2.7 邮件模块

#### 2.7.1 初始步骤


- [nette/mail](https://github.com/nette/mail)

**【nette/mail】**

- 安装

```shell
# 安装路由库
{
  "require": {
      "nette/mail": "*"
  }
}
# 更新
$ php73 composer.phar update
# 注意一下文件变化
vendor/composer
vendor/nette/mail
vendor/nette/utils

```

#### 2.7.2 邮件作用

**功能**

- 核心是给 一批邮件地址 发送邮件内容。一个是目标地址，一个是发送内容。


#### 2.7.3 邮件类`Mail`自动加载操作

```php
# composer配置自动加载
"autoload": {
    "classmap": [
      "services",
    ]
}

# 更新
$ php73 composer.phar dump-autoload

# composer 文件变化
```


#### 2.7.4 邮件类`Mail`执行流程

1. 组件：类。
    - `Mail`组件邮件发送类。继承`Nette\Mail\Message`类；
2. 配置：`config/mail.php`。
    - 关于host, 不同的邮件服务商不同，例如qq是 `smtp.qq.com`、163是`smtp.163.com`；
    - 关于密码，QQ服务，需要在邮件设置->服务中，设置IMAP/SMTP服务，开通第三方授权码登陆；
3. 组件：构造函数。
    - `Mail::to($to)`静态方法。接受要接收的邮件作为参数，并且`Mail`类的对象，返回`$this`;
    - `__construct()` 构造函数中，默认设置`config/mail.php`配置文件中的`username`为发件人（调用 `Message addTo()` ）；
    - `to($to)` 支持字符串，也支持数组，可以发送一封或者多封（调用 `Message setFrom()` ）；
4. 组件：相关方法。
    - `Mail`的公共方法`from()`、`title()`、`content()` 封装了原来的 `Message`的相关方法，加入相关异常判断； 
    - 设置发件人：  `Mail from()`    => `Message setFrom()`
    - 设置邮件标题：`Mail title()`   => `Message setSubject()`
    - 设置邮件内容：`Mail content()` => `Message setHTMLBody()`（可以富文本）
5. 控制器：信息装载。
    - `$this->mail` 成员变量，用来保存邮件组装的信息
    - 在方法中任意为止，可以将 `Mail::to()` 设置的邮件信息对象赋值给，控制器成员变量 `$this->mail`
6. 控制器：发送邮件。
    - 所有控制器，都继承基类`BaseController.php`；
    - 父类`BaseController.php` 会在析构函数`__destruct()`中处理邮件的发送；
    - 单例模式。实例化邮件发送类。`new Nette\Mail\SmtpMailer($mail->config)`；
    - 然后将邮件要发送的信息，`send()`出去；
    - 稍等一会，邮件发送成功；




### 2.8 缓存类Redis模块

> `Redis` 是一个开源的内存数据库服务器。可以用 `Redis` 作为高速缓存，存放系统经常需要访问的数据，但它作用远不止于此，还要看你怎么使用它！

-  字符串（strings）
-  散列（hashes）
-  列表（lists）
-  集合（sets）
-  有序集合（sorted sets）  

#### 2.8.1 初始步骤

> `redis`官方推荐的php客户端是`predis`和`phpredis`。

> `phpredis` 是使用 c 写的 php 扩展； `predis` 是使用纯 php 写的。
 

- [GitHub上高分的PHP操作Redis库](https://github.com/search?l=PHP&o=desc&q=redis&s=stars&type=Repositories)
- [predis/predis](https://github.com/predis/predis)
- [phpredis/phpredis](https://github.com/phpredis/phpredis)


这里选择`predis`,使用`composer`安装方便一些;

当然事先你需要安装 redis服务，以及php的redis扩展，这些你应该都知道~


**【predis/predis】**

- 安装

```shell
# 安装路由库
{
  "require": {
      "predis/predis": "*"
  }
}
# 更新
$ php73 composer.phar update
# 注意一下文件变化
vendor/composer
 
```



#### 2.8.2 Redis作用

**功能**

#### 2.8.3 缓存类`Redis`自动加载操作

**创建Redis缓存类**

- `services/Redis.php`

```php
# composer配置自动加载
"autoload": {
    "classmap": [
      "services",
    ]
}

# 更新
$ php73 composer.phar dump-autoload

# composer 文件变化
```


#### 2.8.4 缓存类`Redis`执行流程

 