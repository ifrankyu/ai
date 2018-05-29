<?php
class CRedis
{
    private $hostname    = null;
    private $port        = null;
    public static $redis = null;

    public function __construct($config)
    {
        $this->hostname = $config->host;
        $this->port     = $config->port;

        if (empty(self::$redis)) {
            try {
                self::$redis = new Redis();
                self::$redis->connect($this->hostname, $this->port);
            } catch (Exception $e) {
                throw new CException('Curl not installed');
            }
        }
    }

    /**
     * 获取一个值
     *
     * @param unknown_type $key
     * @return unknown
     */
    public function get($key)
    {
        return self::$redis->get($key);
    }

    /**
     * 设置一个值
     *
     * @param unknown_type $key
     * @param unknown_type $value
     * @return unknown
     */
    public function set($key, $value)
    {
        return self::$redis->set($key, $value);
    }

    /**
     * 删除
     */
    public function delete($key)
    {
        return self::$redis->delete($key);
    }

    /**
     * 增加一个值
     */
    public function incrBy($key, $num = 1)
    {
        return self::$redis->incrBy($key, $num);
    }

    /**
     * 减少一个值
     */
    public function decrBy($key, $num = 1)
    {
        return self::$redis->decrBy($key, $num);
    }

    /**
     * 设置一个值 并且设置有效期 单位秒
     * @param unknown $key
     * @param number $seconds
     * @param unknown $value
     */
    public function setex($key, $seconds, $value)
    {
        return self::$redis->setex($key, $seconds, $value);
    }

    /**
     * 如果不存在则设置值
     *
     * @param unknown_type $key
     * @param unknown_type $value
     * @return unknown
     */
    public function setnx($key, $value)
    {
        return self::$redis->setnx($key, $value);
    }

    public function lPush($key, $value)
    {
        return self::$redis->lPush($key, $value);
    }

    /**
     * 指定范围里的列表元素。 start 和 end 偏移量都是基于0的下标
     * @param unknown $key
     * @param unknown $start
     * @param unknown $stop
     */
    public function lRange($key, $start, $stop)
    {
        return self::$redis->lRange($key, $start, $stop);
    }

    /**
     * 保留指定范围里的列表元素。 start 和 end 偏移量都是基于0的下标
     * @param unknown $key
     * @param unknown $start
     * @param unknown $stop
     */
    public function ltrim($key, $start, $stop)
    {
        return self::$redis->ltrim($key, $start, $stop);
    }

    public function mget($keys)
    {
        return self::$redis->mget($keys);
    }

    public function exists($key)
    {
        return self::$redis->exists($key);
    }

    /**
     * 设置key的超时时间
     * @param unknown $key
     * @param number $seconds 默认10秒
     */
    public function expire($key, $seconds = 10)
    {
        return self::$redis->expire($key, $seconds);
    }

    /**
     * 自增hash的field的值
     * @param unknown $key
     * @param unknown $field
     * @param number $value
     */
    public function hIncrBy($key, $field, $value = 1)
    {
        return self::$redis->hIncrBy($key, $field, intval($value));
    }

    /**
     * 获取hash中的全部数据
     * @param unknown $key
     */
    public function hGetAll($key)
    {
        return self::$redis->hGetAll($key);
    }

    /**
     * 设置hash数据
     * @param $key
     * @param $hashkey
     * @param $val
     * @return mixed
     */
    public function hset($key, $hashkey, $val)
    {
        return self::$redis->hset($key, $hashkey, $val);
    }

    /**
     * 获取hash数据
     * @param $key
     * @param $hashkey
     * @return mixed
     */
    public function hget($key, $hashkey)
    {
        return self::$redis->hget($key, $hashkey);
    }

    /**
     * 删除hash数据
     * @param $key
     * @param $hashkey
     * @return mixed
     */
    public function hdel($key, $hashkey)
    {
        return self::$redis->hDel($key, $hashkey);
    }

    //返回列表的头元素
    public function lPop($key)
    {
        return self::$redis->lPop($key);
    }

    //加入到列表尾部
    public function rPush($key, $val)
    {
        return self::$redis->rPush($key, $val);
    }
}
