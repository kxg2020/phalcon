<?php
/**
 * redis
 * @authors YangHaiTao (yht@yzgong.com)
 * @date    2016-08-19 14:37:48
 * Created by sublime.
 */

namespace app\library;

class Redis
{
    private static $instances;
    private static $configs;

    public static function getInstance($config)
    {
        $name = $config['name'];

        if (empty(self::$instances[$name])) {
            $redis = new \RedisCluster(NULL, $config['nodes']);

            //如果指定了库，则默认选中指定的库
            self::$instances[$name] = $redis;
            self::$configs[$name] = $config;
        }
        return self::$instances[$name];
    }

    /**
     * 手动关闭链接
     * @param array $names
     * @return bool
     */
    public static function closeInstance(array $names = array())
    {
        if (empty(self::$instances)) {
            return true;
        }

        if (empty($names)) {
            foreach (self::$instances as $name => $redis) {
                $redis->close();
                unset(self::$configs[$name]);
            }
        } else {
            foreach ($names as $name) {
                if (isset(self::$instances[$name])) {
                    self::$instances[$name]->close();
                    unset(self::$configs[$name]);
                }
            }
        }

        return true;
    }
}