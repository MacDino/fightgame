<?php

class Cache
{
    private static $_cacheObj = NULL;

    public static function get($key)
    {
        if(DEVELOPER)
        {
            return FALSE;
            return apc_fetch($key);
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
            return FALSE;
            return apc_add($key, $value, self::$_ttl);
        }else{
            $obj = self::_getCacheObj();
            if($obj)
            {
				return $obj->set($key, $value, MEMCACHE_COMPRESSED ,$ttl);
            }
        }
        return FALSE;
    }

    public static function del($key)
    {
        if(DEVELOPER)
        {
            return FALSE;
            return apc_delete($key);
        }else{
            $obj = self::_getCacheObj();
            if($obj)
            {
                return $obj->delete($key);
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

