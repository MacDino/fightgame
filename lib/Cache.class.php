<?php

class Cache
{
    private static $_cacheObj = NULL;

    public static function get($key)
    {
        if(DEVELOPER)
        {
            return apc_get($key); 
        }else{
            $obj = self::_getCacheObj();
            if($obj)
            {
                $obj->get($key);
            }
        }
        return FALSE; 
    }
    public static function set($key, $value, $ttl = 60)
    {
        if(DEVELOPER)
        {
            return apc_add($key, $value, self::$_ttl); 
        }else{
            $obj = self::_getCacheObj();
            if($obj)
            {
                $obj->set($key, $value, $ttl)
            }
        }
        return FALSE;
    }

    private static function _getCacheObj()
    {
        if(!is_object(self::$_cacheObj))
        {
          if(!DEVELOPER)
          {
              self::$_cacheObj = memcache_init();
          }
        }
        return self::$_cacheObj;
    }
}

