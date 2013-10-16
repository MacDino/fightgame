<?php
class Kvdb
{
	private static $_kvdbObj = NULL;
	
	//获取一个值
	public static function get($key)
	{
		if(DEVELOPER)
		{
			return FALSE;
			return apc_fetch($key);
		}else{
			$obj = self::_getKvdbObj();
			if($obj)
			{
				$obj->get($key);
			}
		}
		return FALSE;
	}
	//获取多个值
	public static function mget($keys)
	{
		if(DEVELOPER)
		{
			return FALSE;
			return apc_fetch($keys);
		}else{
			$obj = self::_getKvdbObj();
			if($obj)
			{
				$obj->mget($keys);
			}
		}
		return FALSE;
	}
	//增加一个值
	public static function add($key, $value)
	{
		if(DEVELOPER)
		{
			return FALSE;
			return apc_add($key, $value);
		}else{
			$obj = self::_getKvdbObj();
			if($obj)
			{
				return $obj->add($key, $value);
			}
		}
		return FALSE;
	}
	//更新一个值
	public static function replace($key, $value)
	{
		if(DEVELOPER)
		{
			return FALSE;
			return apc_store($key, $value);
		}else{
			$obj = self::_getKvdbObj();
			if($obj)
			{
				return $obj->set($key, $value);
			}
		}
		return FALSE;
	}
	//删除一个值
	public static function del($key)
	{
		if(DEVELOPER)
		{
			return FALSE;
			return apc_delete($key);
		}else{
			$obj = self::_getKvdbObj();
			if($obj)
			{
				return $obj->delete($key);
			}
		}
		return FALSE;
	}
	
	private static function _getKvdbObj()
	{
		if(!is_object(self::$_kvdbObj))
		{
			if(!DEVELOPER)
			{
				$res = new SaeKV();
				self::$_kvdbObj = $res->init();
			}
		}
		return self::$_kvdbObj;
	}
}