# PHP-FRAMEWORK-BY-COMPOSER

> 玩一下`composer`搭建框架的流程




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