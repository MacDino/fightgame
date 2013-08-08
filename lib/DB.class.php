<?php
/*
$DB_CONFIG = array(
	'default' => array(
		'host' => '127.0.0.1',
		'database' => 'test',
		'username' => 'root',
		'password' => '',
	),

	'test' => array(
		'host' => '192.168.0.224',
		'database' => 'msg',
		'username' => 'root',
		'password' => '',
		'port' => '3306',
		'charset' => 'utf8',
		'prefix' => '',
		'cache_path' => __DIR__.'/cache/test' // enable cache table structrue by give a cache path
	),
);
//*/

/*
connect to a database and open a table, 
	DB::connection('default')->table('users');

since it`s a default connection, the above clause can be written as: 
	DB::table('users')

connect to default database and execute a raw query
	DB::query('select * from users where user_id = ?', array(1))
	
last information
	DB::lastInsertId();
	DB::lastSql();

table query
	DB::table('users')->select();   // no where
	DB::table('users')->select(1);  // WHERE user_id = ?
	DB::table('users')->select('user_id = 1'); // WHERE user_id = 1
	DB::table('users')->select(array(1,2,3)); // WHERE user_id IN (?,?,?)

	DB::table('users')->select(array(
		'user_name' => 'user_name'
	)); 
	// WHERE user_name = ?
	
	DB::table('users')->select(array(
		'user_name' => '%user_name%'
	))
   	// WHERE user_name LIKE ?

	DB::table('users')->select(array(
		'user_name' => array('name1', 'name2', 'name3')
	)) 
	// WHERE user_name IN (?,?,?)
	
	DB::table('users')->select(array(
		'age >' => 30, 
		'status not in' => array(1, 2, 3)
	));
	// WHERE (age > ?) AND (status NOT IN (?,?,?))

	DB::table('users')->select(array(
		array('age >' => 30), 
		array('user_name' => '%aa%', 'sex' => 1)
	));
	// WHERE (age > ?) OR ((user_name LIKE ?) AND (sex = ?))
	
chain options
	DB::table('users')->field('user_name as name, age, sex')->selectOne();
	DB::table('users')->order('name desc, age asc')->select();
	DB::table('users')->limit('5, 10')->select();
	DB::table('users')->distinct(1)->select();
	DB::table('users')->group('age')->total();


table modify
	DB::table('users')->update(array('user_name' => 'name'), $where);
	DB::table('users')->insert(array('user_name' => 'name'));

	// where in delete is same as in select, except that, when $where is null, select will select all, delete will delete nothing
	DB::table('users')->delete($where);

transaction
	DB::transaction(function(){
		DB::table('users')->insert();
		DB::table('orders')->update();
	});
*/

/**
 * DB frontend for queries
 *
 * @author lishuailong<lishl@bsatinfo.com>
 */
class DB {
	//cache different connections
	public static $connections = array();

	public static function connection($connection = null)
	{
		global $DB_CONFIG;
		if (is_null($connection)) 
		{
			$connection = 'default';
		}

		if ( ! isset(self::$connections[$connection])) 
		{
			$config = $DB_CONFIG[$connection];
			if (is_null($config))
			{
				throw new Exception("database configration not found for $connection");
			}

			$pdo = self::connect($config);
			self::$connections[$connection] = new DBConnection($pdo, $config);
		}

		return self::$connections[$connection];
	}

	public static function connect($config)
	{
		extract($config);

		$dsn = "mysql:host={$host};dbname={$database}";
		if (isset($port))
		{
			$dsn .=";port={$port}";
		}

		$options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);
		$pdo = new PDO($dsn, $username, $password, $options);

		$charset = isset($charset) ? $charset : 'utf8';
		$pdo->exec("set names $charset");

		return $pdo;
	}

	public static function table($table, $connection = null)
	{
		return self::connection($connection)->table($table);
	}

	public static function __callStatic($method, $parameters)
	{
		return call_user_func_array(array(self::connection(), $method), $parameters);
	}
}

/**
 * Connection class, instanced by given configration(database)
 *
 * @author lishuailong<lishl@bsatinfo.com>
 */
class DBConnection {
	
	public $pdo;
	public $config;

	// cache last executed sql 
	protected $last_sql = array();

	// cache opened table
	protected $tables = array(); 

	public function __construct($pdo, $config)
	{
		$this->pdo = $pdo;
		$this->config = $config;
	}

	// open a table for queries
	public function table($table)
	{
		if ( ! isset($this->tables[$table]))
		{
			$this->tables[$table] = new DBQuery($this, $table);
		}

		return $this->tables[$table];
	}

	public function transaction($callback)
	{
		$this->pdo->beginTransaction();

		try 
		{
			call_user_func($callback);
		}
		catch (Exception $e)
		{
			$this->pdo->rollBack();
			throw $e;
		}

		return $this->pdo->commit();
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}

	public function lastSql()
	{
		return $this->last_sql;
	}

	// raw query with bindings
	public function query($sql, $bindings = array())
	{
		$sql = trim($sql);
		list($statement, $result) = $this->execute($sql, $bindings);

		preg_match('/^\w++/', $sql, $matches);
		$action = $matches[0];

		switch (strtolower($action))
		{
		case 'select':
		case 'show':
		case 'desc':
			return $statement->fetchAll(PDO::FETCH_ASSOC);

		case 'update':
		case 'delete':
			return $statement->rowCount();

		default:
			return $result;
		}
	}

	protected function execute($sql, $bindings = array())
	{
		$bindings = (array) $bindings;
		$this->last_sql = array($sql, $bindings);

		try
		{
			$statement = $this->pdo->prepare($sql);
			$result = $statement->execute($bindings);
		}
		catch (Exception $e)
		{
			$error_msg = $e->getMessage();
			$error_msg .= "\n\nSQL: ".$sql."\n\nBindings:".var_export($bindings, true);
			throw new Exception($error_msg);
		}

		return array($statement, $result);
	}
}

/**
 * query class, instanced by given table name
 *
 * @author lishuailong<lishl@bsatinfo.com>
 */
class DBQuery {

	public $connection;

	protected $table_name;
	protected $table_columns;
	protected $primary_key;
	protected $auto_increment;

	protected $components = array(
		'where' => null, 
		'field' => null,
		'order' => null, 
		'limit' => null, 
		'group' => null,
	   	'having' => null,
		'distinct' => null,
	);

	public function __construct(DBConnection $connection, $table)
	{
		$table = trim($table);
		if ( ! $table)
		{
			throw new Exception('empty table name');
		}

		if (isset($connection->config['prefix']))
		{
			$table = $connection->config['prefix'].$table;
		}

		$this->table_name = $table;
		$this->connection = $connection;
		$this->setTable();
	}


	public function tableInfo()
	{
		$fields = $this->connection->query("desc {$this->table_name}");

		$table_info = array('auto_increment' => false);
		foreach ($fields as $field)
		{
			$table_info['table_columns'][] = $field['Field'];

			if ($field['Key'] === 'PRI')
			{
				$table_info['primary_key'] = $field['Field'];
			}

			if ($field['Extra'] === 'auto_increment')
			{
				$table_info['auto_increment'] = true;
			}
		}

		//no primary key ? 
		if ( ! isset($table_info['primary_key']))
		{
			$table_info['primary_key'] = reset($table_info['table_columns']);
		}

		return $table_info;
	}

	public function delete($where = null)
	{
		if (isset($where))
	   	{
			$this->where($where);
		}

		list($sql, $bindings) = $this->compileDelete();
		return $this->query($sql, $bindings);
	}

	public function select($where = null)
	{
		if (isset($where))
		{
			$this->where($where);	
		}

		list($sql, $bindings) = $this->compileSelect();
		return $this->query($sql, $bindings);
	}

	public function selectOne($where = null)
	{
		if ($result = $this->limit(1)->select($where))
		{
			return $result[0];
		}

		return false;
	}


	public function update($params, $where = null)
	{
		if (isset($where))
		{
			$this->where($where);
		}

		list($sql, $bindings) = $this->compileUpdate($params);
		return $this->query($sql, $bindings);
	}


	public function insert($params)
	{
		list($sql, $bindings) = $this->compileInsert($params);
		$result =  $this->query($sql, $bindings);

		if ($result && $this->auto_increment)
		{
			return $this->connection->lastInsertId();
		}

		return $result;
	}

	public function total($where = null)
	{
		if (isset($where))
		{
			$this->where($where);
		}

		list($where, $bindings) = $this->compileWhere();

		$sql = "SELECT count(1) AS count FROM {$this->table_name} {$where}";
		$result = $this->query($sql, $bindings);

		return $result ? $result[0]['count'] : 0;
	}

	// following public can be chained
	public function where($where)
	{
		$this->components['where'] = $this->formatWhere($where);
		return $this;
	}

	public function field($field)
	{
		$this->components['field'] = $field;
		return $this;
	}

	public function order($order)
	{
		$this->components['order'] = $order;
		return $this;
	}

	public function limit($limit)
	{
		$this->components['limit'] = $limit;
		return $this;
	}

	public function group($group)
	{
		$this->components['group'] = $group;
		return $this;
	}

	public function having($having)
	{
		$this->components['having'] = $having;
		return $this;
	}

	public function distinct($distinct)
	{
		$this->components['distinct'] = $distinct;
		return $this;
	}

	public function resetComponents()
	{
		foreach ($this->components as &$component)
		{
			$component = null;
		}

		return $this;
	}

	protected function setTable()
	{
		if (isset($this->connection->config['cache_path']))
		{
			$cache_path = $this->connection->config['cache_path'];
			if ( ! file_exists($cache_path) && ! mkdir($cache_path, 0777, true))
			{
				throw new Exception('unable to create cache dir:'.$cache_path);
			}

			$cache_file = rtrim($cache_path, '/').'/'.$this->table_name.'.php';
			if (file_exists($cache_file))
			{
				$table_info = require($cache_file);
			}
			else
			{
				$table_info = $this->tableInfo();
				if ( ! file_put_contents($cache_file, '<?php return '.var_export($table_info, true).';'))
				{
					throw new Exception('unable to write table info cache:'.$cache_file);
				}
			}
		}
		else
		{
			$table_info = $this->tableInfo();
		}

		$this->table_columns = $table_info['table_columns'];
		$this->primary_key = $table_info['primary_key'];
		$this->auto_increment = $table_info['auto_increment'];
	}


	protected function query($sql, $bindings = array())
	{
		$this->resetComponents();
		return $this->connection->query($sql, $bindings);
	}

	protected function compileDelete()
	{
		$sql = "DELETE FROM {$this->table_name} ";

		list($where, $bindings) = $this->compileWhere();

		// if no where, we give a false clause to avoid disaters
		if ($this->blank($where))
		{
			$sql .= "where {$this->primary_key} = ''";
		}
		else
		{
			$sql .= $where;
		}

		return array($sql, $bindings);
	}

	protected function compileSelect()
	{
		extract($this->components);
		$field = $field ?: implode(',', $this->table_columns);
		list($where, $bindings) = $this->compileWhere();

		$distinct = $distinct ? ' DISTINCT' : '';
		$order = $order ? " ORDER BY $order" : '';
		$limit = $limit ? " LIMIT $limit" : '';
		$group = $group ? " GROUP BY $group" : '';
		$having = $having ? " HAVING $group" : '';

		$sql = "SELECT{$distinct} {$field} FROM {$this->table_name} {$where}{$group}{$having}{$order}{$limit}";
		return array($sql, $bindings);
	}

	protected function compileUpdate(array $params)
	{
		$params = array_intersect_key($params, array_flip($this->table_columns));
		if ( ! $params )
		{
			throw new Exception('column not exists');
		}

		$columns = array_keys($params);
		$bindings = array_values($params);

		$sets = array();
		foreach ($params as $column => $value)
		{
			$sets[] = "{$column} = ?";
		}
		$sets = implode(', ', $sets);

		list($where, $_bindings) = $this->compileWhere();
		$bindings = array_merge($bindings, $_bindings);
		
		$sql = "UPDATE {$this->table_name} SET $sets $where";
		return array($sql, $bindings);
	}

	protected function compileInsert(array $params)
	{
		$params = array_intersect_key($params, array_flip($this->table_columns));
		if ( ! $params )
		{
			throw new Exception('column not exists');
		}

		$columns = array_keys($params);
		$bindings = array_values($params);

		$values = implode(', ', array_fill(0, count($bindings), '?'));
		$columns = implode(', ', $columns);

		$sql = "INSERT INTO {$this->table_name} ({$columns}) VALUES ({$values})";
		return array($sql, $bindings);
	}

	// empty value except 0
	public function blank($value)
	{
		return	empty($value) && ! is_numeric($value);
	}

	/**
	 * format where parameters to a compile friendly array
	 * return array on success, null on failure
	 */
	protected function formatWhere($where)
	{
		if ($this->blank($where))
		{
			return null;
		}

		// number
		if (is_numeric($where))
		{
			return array($this->primary_key, '=', $where);
		}

		// string
		if (is_string($where))
		{
			return array('', 'sql', $where);
		}

		// array
		if (is_array($where))
		{
			// index one-dimension array
			if (isset($where[0]) && ! is_array($where[0]))
			{
				return array($this->primary_key, 'in', $where);
			}

			// index multi-dimension array
			if (isset($where[0]))
			{
				$wheres = array_filter(array_map(array($this, 'formatWhere'), $where));

				if ($wheres)
				{
					$wheres['connector'] = 'OR';
					return $wheres;
				}

				return null;
			}

			// assoc array
			$wheres = array();
			foreach ($where as $column => $value)
			{
				$column = trim($column);
				preg_match('/^(\w++)(.*)$/', $column, $match);

				list(,$column_name, $operator) = $match;
				$operator = trim($operator);
				if ($operator)
				{
					$wheres[] = array($column_name, $operator, $value);
					continue;
				}


				if (is_array($value))
				{
					$wheres[] = array($column_name, 'in', $value);
					continue;
				}

				if (is_string($value) && $value[0] === '%' && substr($value, -1) === '%')
				{
					$wheres[] = array($column_name, 'like', $value);
					continue;
				}

				$wheres[] = array($column_name, '=', $value);
			}

			$wheres['connector'] = 'AND';
			return $wheres;
		}
	}

	protected function compileWhere($where = null)
	{
		if ( ! isset($where))
		{
			$where = $this->components['where'];
		}

		if ( ! isset($where))
		{
			return array('', array());
		}

		if (is_array($where[0])) 
		{
			$sql = $bindings = array();
			$connector = $where['connector'];
			unset($where['connector']);
			foreach ($where as $one)
			{
				list($_sql, $_bindings) = $this->compileWhere($one);
				if ( ! $_sql)
				{
					continue;
				}

				// remove ' WHERE '
				$sql[] = '('.substr($_sql, 7).')';
				$bindings = array_merge($bindings, $_bindings);
			}

			if ( ! $sql)
			{
				return array('', array());
			}

			if (count($sql) === 1)
			{
				$sql[0] = substr($sql[0], 1, -1);
			}

			$sql = implode(" $connector ", $sql);
			$sql = " WHERE $sql";
			return array($sql, $bindings);
		}

		list($column, $operator, $value) = $where;
		$operator = strtoupper($operator);
		switch($operator)
		{
		case 'IN':
		case 'NOT IN':
			$value = (array) $value;

			$bindings = array_filter($value, function($v){
				return is_scalar($v);
			});
			$in = $bindings ? implode(',', array_fill(0, count($bindings), '?')) : "''";
			$sql = "$column $operator ($in)";
			break;

		case 'SQL':
			$bindings = array();
			$sql = $value;
			break;

		default:
			$sql = "$column $operator ?";
			$bindings = array($value);
			break;
		}

		$sql = ' WHERE '.$sql;
		return array($sql, $bindings);
	}
}
