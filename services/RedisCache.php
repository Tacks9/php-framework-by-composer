<?php

/*
 * @Descripttion: Redis组件库
 * @Author: tacks321@qq.com
 * @Date: 2021-08-31 15:12:46
 * @LastEditTime: 2021-08-31 16:12:29
 */

use Predis\Client;

class RedisCache {
    const CONFIG_FILE = '/config/redis.php';
    
    protected static $redis;

    public static function init()
    {
        // 实例化客户端
        self::$redis = new Client(require BASE_PATH . self::CONFIG_FILE);
    }


    /**
     * 设置字符串过期时间
     *
     * @date  2021-08-31 15:39:51
     * @param string $key
     * @param string $value
     * @param string $time
     * @param string $unit
     */
    public static function set($key, $value, $time=null, $unit=null)
    {
        // 实例化客户端
        self::init();
        if($time) {
            // 时间单位判断
            switch($unit) {
                case 'h':
                    $time *= 3600;
                    break;
                case 'm':
                    $time *= 60;
                    break;
                case 's':
                case 'ms':
                    break;
                default:
                    throw new InvalidArgumentException('单位只能是 h m s ms');
                    break;
            }

            if ($unit=='ms') {
                self::_psetex($key,$value,$time);
            } else {
                self::_setex($key,$value,$time);
            }

        } else {
            self::$redis->set($key,$value);
        }

    }


    /**
     * 获取字符串值
     *
     * @param string $key 键名
     */
    public static function get($key)
    {
        self::init();
        return self::$redis->get($key);
    }

    /**
     * 删除元素key
     *
     * @param string $key 键名
     */
    public static function delete($key)
    {
        self::init();
        return self::$redis->del($key);
    }

    /**
     * 设置过期时间（秒）
     *       SETEX KEY_NAME TIMEOUT VALUE
     *
     * @param string $key
     * @param string $value
     * @param string $time
     * @return void
     */
    private static function _setex($key, $value, $time) {
        self::$redis->setex($key, $time, $value);
    }

    /**
     * 设置过期时间（毫秒）
     *       PSETEX key1 EXPIRY_IN_MILLISECONDS value1 
     * 
     * @param string $key
     * @param string $value
     * @param string $time
     */
    private static function _psetex($key, $value, $time) {
        self::$redis->psetex($key, $time, $value);
    }
    
}