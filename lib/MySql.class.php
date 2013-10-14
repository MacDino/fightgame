<?php
class MySql
{
	private static $_mySqlConfigKey = 'default';
	private static $_db  = array();
	private static $_sql = NULL;
	
	//设置本次连接MYSQL所需要的配置，默认为default
	public static function setMysqlConfigKey($keyName = 'default')
	{
		if($keyName)self::$_mySqlConfigKey = $keyName;
	}
	//切换数据链接对象
	public static function switchMysql($keyName = 'default')
	{
		if($keyName)self::setMysqlConfigKey($keyName);
	}
	//获取当前执行的错误信息
	public static function getError()
	{
		$db = self::_connectMysql();
		return array("msg" 	=> $db->errorInfo(),
					 "code" => $db->errorCode(),
					 );
	}
	//获取当前执行的最后一条SQL
	public static function getLastSQL()
    {
        return self::$_sql;
    }
    //开始执行事务
    public static function beginTransaction()
    {
        $db = self::_connectMysql();
        return $db->beginTransaction();
    }
    //事务回滚
    public static function rollBack()
    {
        $db = self::_connectMysql();
        return $db->rollBack();
    }
    //事务提交
    public static function commit()
    {
        $db = self::_connectMysql();
        return $db->commit();
    }
    //执行无反回结果的SQL
    public static function execute($sql)
    {   
        try{
        	$db = self::_connectMysql();
			$result = $db->prepare($sql);
			self::$_sql = $sql;
			return $result->execute();
        }catch(Exception $e){
            return FALSE;
        }   
    }
    //执行有返回结果的SQL
    public static function query($sql)
    {   
        try{
        	$db = self::_connectMysql();
            $result = $db->prepare($sql);
			self::$_sql=$sql;
			$result->execute();
			return $result->fetchAll(PDO::FETCH_ASSOC);
        } catch ( PDOException $e ) { 
            return FALSE;
        }   
    }
    //更新数据
    public static function update($tableName, $dataArray, $whereArray=NULL, $fieldArray = NULL)
    {
    	if(!$tableName || !$dataArray)return FALSE;
    	$setValue = '';
    	foreach ($dataArray as $key => $value)
    	{
    		if($key  && is_string($key))
    		{
	    		$setValue .= "`".$key."` = '".$value."',";  	    		
    		}
    	}
    	$sql = "UPDATE $tableName SET ".substr($setValue, 0, -1).self::_whereCondition($whereArray);
//    	echo $sql;
    	return self::execute($sql);
    }
    //获取数据
    public static function select($tableName, $whereArray = NULL, $fieldArray = NULL, $orderArr = NULL, $start = NULL, $limit = NULL)
    {
    	if(!$tableName)return FALSE;
    	$sql = "SELECT ".($fieldArray?'`'.implode('`,`', array_values($fieldArray)).'`':'*')." FROM $tableName".self::_whereCondition($whereArray) . self::_orderCondition($orderArr);
    	if (!empty($limit)) {
    		$sql .= " LIMIT $start,$limit";
    	}
//    	echo $sql;
    	return self::query($sql);
    }
    //获取一条数据
    public static function selectOne($tableName, $whereArray = NULL, $fieldArray = NULL, $orderArr = NULL)
    {
    	$result = self::select($tableName, $whereArray, $fieldArray, $orderArr, 0, 1);
   		if($result && isset($result[0]))
		{
			return $result[0];
		}else{
			return NULL;
		}
    }
    //根据条件计算数量
    public static function selectCount($tableName, $whereArray = NULL){
    	if(!$tableName)return FALSE;
    	$sql = "SELECT count(1) as c FROM $tableName".self::_whereCondition($whereArray);
    	$result = self::query($sql);
		return isset($result[0]['c']) ? (int)$result[0]['c'] : 0;
	}
    //删除数据
    public static function delete($tableName, $whereArray = NULL)
    {
    	if(!$tableName || !$whereArray)return FALSE;
    	$sql = "DELETE FROM $tableName".self::_whereCondition($whereArray);
    	return self::execute($sql);
    }   
    //插入数据
    public static function insert($tableName, $dataArray, $needInsertId = FALSE)
    {
		if(!$tableName || !$dataArray)return FALSE;
		$sql = "INSERT INTO $tableName (`".implode('`,`', array_keys($dataArray))."`) VALUES ('".implode("','", array_values($dataArray))."')";	
//		echo $sql;exit;
		$res = self::execute($sql);
		if($needInsertId && $res)
		{
			try{
				$db = self::_connectMysql();
				$id = $db->lastInsertId();
				return $id;
			}catch(Exception $e){
	            return FALSE;
	        }
		}
		return $res;
    }
    //将where数组翻译成sql字符串
    public static function tranferCondition($where)
    {
        return self::_whereCondition($where);
    }
    //拼装ORDER条件
    private static function _orderCondition($orderArr)
    {
    	if ($orderArr) {
    		return " ORDER BY ".implode(",", $orderArr);
    	}
    	return "";
    }
    //拼装WHERE条件
    private static function _whereCondition($whereArray)
    {
    	if($whereArray)
    	{
	    	$tmpArr = array();
	    	foreach ($whereArray as $key => $data) {
				$opt = '=';
				$val = $data;
				if(is_array($data)){
					if(isset($data['opt']))	{
						$opt = $data['opt'];
						$val = $data['val'];
            			if(isset( $data['valex']))
                        {
                            $valex = $data['valex'];
                        }
					} else{
						foreach($data as $dal){
							$tmpArr[] = "{$key} ".$dal['opt']." '".$dal['val']."'";
						}
						continue;
					}
				}

				if($opt == 'in' || $opt == 'not in') {
					$tmpArr[] = "`{$key}` {$opt} ({$val})";
				} else if ($opt == 'like') {
					$tmpArr[] = "`{$key}` {$opt} '%{$val}%'";
				} else if ($opt == 'between') {
			                $tmpArr[] = "`{$key}` >= '{$val}' and `{$key}` <= '{$valex}'";
				} else {
					$tmpArr[] = "`{$key}` {$opt} '{$val}'";
				}
	    	}
    		return " WHERE ".implode(" AND ", $tmpArr);
    	}
    	return "";
    }
	//连接数据库
	private static function _connectMysql()
	{
		if(empty(self::$_mySqlConfigKey))throw new Exception("Not set Mysql Config Key!", 999);
		if(!isset(self::$_db[self::$_mySqlConfigKey]) || !is_object(self::$_db[self::$_mySqlConfigKey]))
		{
			global $MYSQL_CONFIG;
			$dbConfig = isset($MYSQL_CONFIG[self::$_mySqlConfigKey])?$MYSQL_CONFIG[self::$_mySqlConfigKey]:NULL;
			if(!$dbConfig)throw new Exception("Not Find Mysql Config!", 999);
			$dsn = "mysql:host=".$dbConfig['db_host'].";dbname=".$dbConfig['db_name'].";port=".$dbConfig['db_port'].";";
			try{
				self::$_db[self::$_mySqlConfigKey] = new PDO($dsn, $dbConfig['db_user'], $dbConfig['db_passwd']);
				self::$_db[self::$_mySqlConfigKey]->exec("SET NAMES UTF8;");
			} catch (PDOException $e) {
				throw new Exception($e->getMessage(), $e->getCode());
			}
            
		}
		return self::$_db[self::$_mySqlConfigKey];
	}
}
