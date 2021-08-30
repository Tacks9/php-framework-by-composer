<?php
/*
 * @Descripttion: 模型Model
 * @Author: tacks321@qq.com
 * @Date: 2021-08-27 16:58:32
 * @LastEditTime: 2021-08-30 10:11:33
 */

class Article 
{
    // 获取数据
    public static function getAll()
    {
        // database 载入数据库的配置
        $CONFIG_DATABASE = require '../config/database.php';

        // Mysqli 链接数据库
        $host     = $CONFIG_DATABASE['host'];
        $username = $CONFIG_DATABASE['username'];
        $password = $CONFIG_DATABASE['password'];
        $dbname   = $CONFIG_DATABASE['dbname'];
        $port     = $CONFIG_DATABASE['port'];

        // 创建连接
        $conn = new mysqli($host, $username, $password, $dbname, $port);
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        } 
        $conn->query("SET NAMES utf8");

        // 查询数据库
        $sql = "SELECT id, title FROM article";
        $result = $conn->query($sql);

        // 返回的数据
        $list = [];

        if ($result->num_rows > 0) {
            // 输出数据
            while($row = $result->fetch_assoc()) {
                // echo "id: " . $row["id"]. " - title: " . $row["title"]. "<br>";
                array_push($list, ['id'=>$row["id"], 'title'=>$row["title"] ]);
            }
        } else {
            // echo "0 结果";
            $list = [];
        }

        $conn->close();

        return $list;

    }


    // 获取最新的5条数据
    public static function getList()
    {
        // database 载入数据库的配置
        $CONFIG_DATABASE = require '../config/database.php';

        // Mysqli 链接数据库
        $host     = $CONFIG_DATABASE['host'];
        $username = $CONFIG_DATABASE['username'];
        $password = $CONFIG_DATABASE['password'];
        $dbname   = $CONFIG_DATABASE['dbname'];
        $port     = $CONFIG_DATABASE['port'];
        $options  = [  
            // 持久化链接
            PDO:: ATTR_PERSISTENT => true
        ];
        $pdo    = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password, $options);
        $fluent = new \Envms\FluentPDO\Query($pdo);

        // 查询最新的5条数据
        $query = $fluent->from('article')
                    ->orderBy('id DESC')
                    ->limit(5);
    
        // 查询获取所有数据
        $list = $query->fetchAll();

        return $list;

    }

    
    // 获取最新的
    public static function getArticle()
    {
        // database 载入数据库的配置
        $CONFIG_DATABASE = require '../config/database.php';

        // Mysqli 链接数据库
        $host     = $CONFIG_DATABASE['host'];
        $username = $CONFIG_DATABASE['username'];
        $password = $CONFIG_DATABASE['password'];
        $dbname   = $CONFIG_DATABASE['dbname'];
        $port     = $CONFIG_DATABASE['port'];
        $options  = [  
            // 持久化链接
            PDO:: ATTR_PERSISTENT => true
        ];
        $pdo    = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password, $options);
        $fluent = new \Envms\FluentPDO\Query($pdo);

        // 查询最新的5条数据
        $query = $fluent->from('article')
                    ->orderBy('id DESC')
                    ->limit(1);
    
        // 查询获取
        $data = $query->fetch();

        return $data;

    }

}