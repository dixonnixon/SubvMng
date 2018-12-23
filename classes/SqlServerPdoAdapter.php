<?php
class SqlServerPdoAdapter implements IDataBaseAdapter
{
	protected static $dbh;
	protected $stmt;
	protected $fetchMode = PDO::FETCH_ASSOC;
	

	public function startConnection() {
		if(self::$dbh) {return $this;}
		self::$dbh = &UniversalConnect::doConnect("");
		return $this;
	}
	
	public function endConnection() {
		self::$dbh = null;
	}
	
	public static function getConnection() {
		if(self::$dbh === NULL) {
			throw new PDOException("Немає об'єкта PDO для підключення");
		}
		return self::$dbh;
	}
	
	public static function closeConnection() {
		self::$dbh = NULL;
	}
	

	public function prepare($sql, array $options = array()){
		$this->startConnection();
		try{
			$this->stmt = self::$dbh->prepare($sql, $options);
		} catch(PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	//Binds the prep statement
	public function bind($param, $value, $type = null) {
 		if (is_null($type)) {
  			switch (true) {
    			case is_int($value):
      				$type = PDO::PARAM_INT;
      				break;
    			case is_bool($value):
      				$type = PDO::PARAM_BOOL;
      				break;
    			case is_null($value):
      				$type = PDO::PARAM_NULL;
      				break;
				default:
      				$type = PDO::PARAM_STR;
  			}
			$this->stmt->bindValue($param, $value, $type);
		} elseif($type == "param") {
			switch (true) {
    			case is_int($value):
      				$type = PDO::PARAM_INT|PDO::PARAM_INPUT_OUTPUT;
      				break;
    			case is_bool($value):
      				$type = PDO::PARAM_BOOL|PDO::PARAM_INPUT_OUTPUT;
      				break;
    			case is_null($value):
      				$type = PDO::PARAM_NULL|PDO::PARAM_INPUT_OUTPUT;
      				break;
				default:
      				$type = PDO::PARAM_STR|PDO::PARAM_INPUT_OUTPUT;
  			}
			$this->stmt->bindParam($param, $value, $type);
		}
	}
	
	
	
	//для декількох параметрів у вигляді масива
	//вотето я долго тупил)
	public function bindParameters($array, $type = null) {
		foreach($array as $id => $value) {
			$this->bind($id, $value, $type);
		}
	}
	
	public function getStatement() {
		if(is_null($this->stmt)) {
			throw new PDOException("No PDO Objects for use");
		}
		return $this->stmt;
	}
 
	public function execute() {
		if($this->stmt->execute()) {
			return $this;
		} else {
			return;
		}
	}

	public function fetchAll($fetchStyle = null, $column = 0){
		if ($fetchStyle === null) {
			$fetchStyle = $this->fetchMode;
		}		
		$this->execute();
		return ($fetchStyle === PDO::FETCH_COLUMN)
			? $this->getStatement()->fetchAll($fetchStyle, $column)
			: $this->getStatement()->fetchAll($fetchStyle);
	}
	
	
	public function countAffectedRows() {
		try {
			return $this->stmt->rowCount();
			
		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}

	public function lastInsertId($name = NULL){
		self::getConnection();
		
		return self::$dbh->lastInsertId($name);
	}
	
	public function begin(){
		self::$dbh->beginTransaction();
	}
	
	public function rollBack(){
		self::$dbh->rollBack();
	}
	
	public function commit(){
		return self::$dbh->commit();
	}

	public function fetch(
		$fetchStyle = null,
		$cursorOrientation = null, 
		$cursorOffset = null
	) 
	{
		if ($fetchStyle === null) {
			$fetchStyle = $this->fetchMode;
		}
		
		try {
			if($this->execute() == true) {
				return $this->stmt->fetch(
					$fetchStyle, 
					$cursorOrientation, 
					$cursorOffset
				);
			} elseif($this->execute() == false) {
				echo "<br>Невірне значення $field : $value або сталася помилка<br>";
			}	
		} catch (PDOException $e) {
			throw new RunTimeException($e->getMessage());
		}
	}
	
	public function getMeta() {
		return $this->stmt->getColumnMeta(0);
	}
	
	public function selectFn($table, array $bind = array()) {
		// print_r($table);
		// print_r($bind);
		$cols = implode(", ", array_keys($bind));
		$values = implode(", :", array_keys($bind));
		foreach ($bind as $col => $value) {
			unset($bind[$col]);
			$bind[":" . $col] = $value;
		}
		
		// $sql = "INSERT INTO " . $table
		// . " (" . $cols . ") VALUES (:" . $values . ")";
		
		
		$sql = "SELECT * FROM " . $table  
		. " (:" . $values . ")";
		
		// print_r($sql);
		$this->prepare($sql);
		$this->bindParameters($bind);
		$this->stmt->execute();
		return $this;
	}

	
	
	public function Proc($proc, $bindVal) 
	{
		$bind = array_keys($bindVal);
		$where = array();
		
		// print_r($bindVal);
		// print_r($bind);

		
		foreach ($bindVal as $col => $value) {
			$where[] = " " . $bindVal[$col] . " ";
			
		}
		
		$where = implode(" , ", $where);
		// echo "" . $where . "";
		// print_r($bind);
		// print_r($strPar);
		// print_r(implode(" " . "AND" . " ", $strPar));
		// print_r($where);
		
		$sql = "EXEC  {$proc} {$where}";
		
		
		 // echo "<pre>";
		 // print_r($sql);
		 // echo "</pre>";
		$this->prepare($sql);
		// $this->bindParameters($bind);
		// $this->bindParameters($bindVal);
		// $this->stmt->execute($bindVal);
		return $this->stmt->execute($bindVal);
	}
	
	public function selectSimple($table, $strPar, $bindVal) 
	{
		$bind = array_keys($bindVal);
		$where = array();
		
		foreach ($strPar as $col => $value) {
			$where[] = " " . $strPar[$col] . " = " . $bind[$col];
		}
		
		$where = implode(" AND ", $where);
		// echo "" . $where . "";
		// print_r($bind);
		// print_r($strPar);
		// print_r(implode(" " . "AND" . " ", $strPar));
		
		$sql = "SELECT * from {$table} 
		WHERE {$where}";
		
		
		// print_r($sql);
		$this->prepare($sql);
			// $this->bindParameters($bind);
		$this->bindParameters($bindVal);
		$this->stmt->execute($bindVal);
		return $this;
	}
	
	public function select(
		$table, 
		array $bind = array(),
		$boolOperator = "AND",
		array $columns = array()) 
	{
			if ($bind) {
				// echo "<pre>bind\n";
				// print_r($bind);
				// echo "bind\n</pre>";
				$where = array();
				foreach ($bind as $col => $value) {
					unset($bind[$col]);
					$bind[":" . $col] = $value;
					$where[] = $col . " = :" . $col;
				}
			}
			
			if($columns)
			{
				$sel = array();
				foreach ($columns as $col => $value) {
					// print_r($col);
					// print_r($value);
					
					$sel[] = $value;
				}
			}
			
			$sql = "SELECT " 
				. (($columns) ?
					implode(", ", $sel) : " * "
				) 					
				." FROM " . $table
				. (($bind) ? " WHERE "
					. implode(" " . $boolOperator . " ", $where) : " "
				);
				
			
			// print_r($bind);
			
			// echo $sql;
			// echo "<pre>";
			// print_r(debug_backtrace());
			// echo "</pre>";
			$this->prepare($sql);
			// $this->bindParameters($bind);
			$this->bindParameters($bind);
			$this->stmt->execute($bind);
			return $this;
	}
	
	public function insertManyToOne($table, array $bind) 
	{
		$columnList = array_keys($bind);
		// print_r($columnList);
		$cols = implode(", ", $columnList);
		$values = 
			"VALUES (:" . implode(", :", array_keys($bind)). ")";
		foreach ($bind as $col => $value) {
			// unset($bind[$col]);
			$tempCols[":" . $col] = $value;
			
			if(is_array($value)) {
				
				$values = "VALUES ";
				// print_r($bind);
				
				// print_r($value);
				
				foreach($value as $key => $valuMult) {
					// unset($bind);
					unset($bind[$col]);
					$valuesList[] = "(" 
					. ":" . $columnList[0] . $key .", " 
					. ":" . $col . $key .")";
				
					$bindCols[ ":".$col.$key]
						= $valuMult;
					$bindCols[ ":".$columnList[0].$key]
						= $bind[$columnList[0]];
					
				}
				
				$values .= implode(", ", $valuesList);
				// print_r($values);
				
				
				
			} else {
				
				// $bindCols[":" . $col] = $value;
				// var_dump($list);
				// echo "tmp";
				// print_r($tempCols);
				// print_r(key($tempCols));
				
			}
		}
		
		
		$sql = "INSERT INTO " . $table
		. " (" . $cols . ") " . $values ;
		echo $sql;
		print_r($bindCols);
		$this->prepare($sql);
		$this->stmt->execute($bindCols);
		return (int) $this->lastInsertId();
	}
	
	public function insert($table, array $bind) {
		$cols = implode(", ", array_keys($bind));
		$values = implode(", :", array_keys($bind));
		foreach ($bind as $col => $value) {
			unset($bind[$col]);
			$bind[":" . $col] = $value;
		}
		$sql = "INSERT INTO " . $table
		. " (" . $cols . ") VALUES (:" . $values . ")";
		// echo $sql;
		// print_r($bind);
		$this->prepare($sql);
		$this->stmt->execute($bind);
		return (int) $this->lastInsertId();
	}
	
	
	
	
	public function update($table, array $bind, $where = "") {
		// print_r($bind);
		$set = array();
		foreach ($bind as $col => $value) {
			unset($bind[$col]);
			$bind[":" . $col] = $value;
			$set[] = $col . " = :" . $col;
		}
		$sql = "UPDATE " . $table . " SET " . implode(", ", $set)
		. (($where) ? " WHERE " . $where : " ");
		
		// echo "--------------------------<br>";
		print_r($bind);
		echo $sql;
		
		
		$this->prepare($sql);
		$this->bindParameters($bind);
		$this->stmt->execute();
		
		
		return (int) $this->countAffectedRows();
	}
	
	public function deleteManyFromOne(
		$table, $where) 
	{
		// print_r($where);
		// $strWhere = implode(" {$boolOperator} " , $where);
		$sql = "DELETE FROM " . $table . (($where) ? " WHERE " . $where : " ");
		
		// print_r($where);
		echo $sql;
		
		$this->prepare($sql);
		$this->stmt->execute();
		return (int) $this->countAffectedRows();
	}
	
	public function delete($table, $where = "") {
		
		$sql = "DELETE FROM " . $table . (($where) ? " WHERE " . $where : " ");
		
		// print_r($where);
		echo $sql;
		
		$this->prepare($sql);
		$this->stmt->execute();
		// echo $this->countAffectedRows();
		
		return (int) $this->countAffectedRows();
	}
}