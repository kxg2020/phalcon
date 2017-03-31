<?php

class XMemCache
{
    protected static $_instance = null;
    protected $_memobj = null;
    final protected function __construct() {
        $this->_GetObject();
    }

    public static function getInstance()
    {
        if (null === self::$_instance)
        {
            self::$_instance = new self();
        }

        return self::$_instance;
    }


    /**
     * 替换缓存值  若不存在则新增，若存在则相加
     * @param unknown_type $key
     * @param unknown_type $info
     * @param unknown_type $timeout
     * @param unknown_type $iszip
     */
    public function replace($key,$info,$timeout=604800,$iszip=0){
        if($r=$this->Get($key)){
            $info=array_merge($info,$r);
        }
        $this->Set($key,$info,$timeout,$iszip);


    }


    /**
     * Enter 添加缓存
     * @param <string> $key 键名
     * @param <string> $info
     * @param <int> $iszip
     * @param <int> $timeout 0永久有效，604800 7天，最大不能超过30天
     */
    public function set($key,$info,$timeout=604800,$iszip=0){
        $info=serialize($info);
        return $this->_memobj->set($key, $info,$iszip,$timeout);
    }

    /**
     * 根据KEY获得内容
     * @param unknown_type $key
     */
    public function get($key)
    {
        $r=$this->_memobj->get($key);
        return unserialize($r);
    }

    /**
     * 删除缓存KEY
     * @param unknown_type $key
     */
    public function delete($key)
    {
        return $this->_memobj->delete($key);
    }

    /**
     * 获得对象
     */
    protected function _GetObject()
    {
        if(null == $this->_memobj)
        {
            $this->_memobj = new Memcache;
            //读取配置文件
            global $G_X;
            if(empty($G_X['memcacheserver'])){
                return false;
            }
            foreach($G_X['memcacheserver'] as $mem){
                $this->_memobj->addServer($mem['host'], $mem['port']);
            }

        }

        return $this->_memobj;
    }

    /**
     * memcache 缓存的伪命名空间，适用于缓存key的生成和缓存的模糊删除
     * 删除
     * 如要删除 key 以list为前缀的所有缓存，cacheKeyHandle('list',true);
     * 如要删除 key 以user:5为前缀的所有缓存，cacheKeyHandle(['user',5],true);
     *
     * 获取key
     * 如获取以list为前缀的命名空间key，cacheKeyHandle('list',2,3,4); 参数可以任意多个
     * 如获取以user:5为前缀的命名空间key，cacheKeyHandle(['user',5],3,5);参数可以任意多个
     * @return
     */
    public function cacheKeyHandle()
    {
        //如果第一个参数是数组，表示这个数组中的值都参与key的伪命名空间
        $parmsNum = func_num_args();
        if($parmsNum == 0){
            return '没有传参';
        }

        $params = func_get_args();
        $firstP = array_shift($params);


        //命名空间key
        $namespaceKey = '';
        if(is_array($firstP)){

            if(empty($firstP)){
                return '第一个参数不能传空数组';
            }

            foreach($firstP as $space){
                $namespaceKey .= $space.':';
            }

            $namespaceKey = rtrim($namespaceKey,':');

        }else{

            if(!$firstP){
                return '第一个参数不能为空';
            }
            $namespaceKey = $firstP;
        }

        //如果最后一个参数为true,表示要删除当前的命名空间
        $isDelete = end($params);

        if($isDelete === true){
            return $this->delete($namespaceKey);
        }

        //先从缓存中获取
        $namespaceValue = $this->get($namespaceKey);

        //如果缓存中没有，则产生一个随机串并写入缓存
        if(!$namespaceValue){

            $namespaceValue = time().rand(100,999);
            $this->set($namespaceKey,$namespaceValue,0);
        }

        //拼接key
        $namespaceKey .= ':'.$namespaceValue.':'.implode(':',$params);

        return $namespaceKey;
    }
}
