<?php

class Counter
{
    private static $_counterObj = NULL;
    private static $_ttl = 36000;
    /**
     *  (string) $key
     *  (int) $value
     */ 
    public static function create($key, $value)
    {
        if(!$key || !$value)return FALSE;
        if(DEVELOPER)
        {
            return apc_add($key, $value, self::$_ttl);
        }else{
            $obj = self::_getCounterObj();
            return $obj->create($key, $value);
        }
    }

    /**
     *  (string) $key
     */
    public static function remove($key)
    {
        if(!$key)return TRUE;
        if(DEVELOPER)
        {
            return apc_delete($key);
        }else{
            $obj = self::_getCounterObj();
            return $obj->remove($key);
        }
    }
    /**
     *  (string)$key
     */
    public static function exists($key)
    {
        if(!$key)return FALSE;
        if(DEVELOPER)
        {
            return apc_exists($key);
        }else{
            $obj = self::_getCounterObj();
            return $obj->exists($key);
        }
    }
    /**
     *  (string)$key
     */
    public static function get($key)
    {
        if(!$key)return NULL;
        if(DEVELOPER)
        {
            return apc_fetch($key);
        }else{
            $obj = self::_getCounterObj();
            return $obj->get($key);
        }
    }
    /**
     *  (string)$key
     *  (int)$value
     */
    public static function set($key, $value)
    {
        if(!$key || !$value)return FALSE;
        if(DEVELOPER)
        {
            return apc_store($key, $value);
        }else{
            $obj = self::_getCounterObj();
            return $obj->set($key, $value);
        }
    }
    /**
     *  (array)$keys
     */
    public static function mget($keys)
    {
        if(!$keys || is_array($keys))return array();
        if(DEVELOPER)
        {
            foreach($keys as $key)
            {
                $getValues[$key] = self::get($key);
            }
            return $getValues;
        }else{
            $obj = self::_getCounterObj();
            return $obj->mget($keys); 
        }
    
    }
    /**
     *  (string) $key
     *  (int) $value
     */
    public static function incr($key, $value = 1)
    {
        if(!$key)return FALSE;
        if(DEVELOPER)
        {
            return apc_inc($key, $value);
        }else{
            $obj = self::_getCounterObj();
            return $obj->incr($key, $value);
        }
    }
    /**
     *  (string) $key
     *  (int) $value
     */
    public static function decr($key, $value = 1)
    {
        if(!$key)return FALSE;
        if(DEVELOPER)
        {
            return apc_dec($key, $value);
        }else{
            $obj = self::_getCounterObj();
            return $obj->decr($key, $value);
        }
    }
    
    private static function _getCounterObj()
    {
        if(!is_object(self::$_counterObj))
        {
          if(!DEVELOPER)
          {
              self::$_counterObj = new SaeCounter;
          }
        }
        return self::$_counterObj;
    }
}
