# PHP-FRAMEWORK-BY-COMPOSER

> 玩一下`composer`搭建框架的流程


## 0 学习资料

- [利用 Composer 一步一步构建自己的 PHP 框架（一）——基础准备](http://lvwenhan.com/php/405.html)
- [利用 Composer 一步一步构建自己的 PHP 框架（二）——构建路由](http://lvwenhan.com/php/406.html)
- [利用 Composer 一步一步构建自己的 PHP 框架（三）——设计 MVC](https://lvwenhan.com/php/408.html)
- [利用 Composer 一步一步构建自己的 PHP 框架（四）——使用 ORM](http://lvwenhan.com/php/409.html)


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

```sql
DROP TABLE IF EXISTS `article`;

CREATE TABLE `article` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `article` WRITE;
/*!40000 ALTER TABLE `article` DISABLE KEYS */;

INSERT INTO `article` (`id`, `title`)
VALUES
	(1,'打印机没墨了'),
	(2,'打印机测试');

/*!40000 ALTER TABLE `article` ENABLE KEYS */;
UNLOCK TABLES;

```

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

 

 




### 2.4 视图

#### 2.4.1 初始步骤

- `app/views` 视图目录
- 控制器获取模型数据，然后 `require` 控制器引入视图模板，渲染html

