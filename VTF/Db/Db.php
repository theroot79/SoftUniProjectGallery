<?php

namespace VTF\Db;

/**
 * Database class
 *
 * Class Db
 * @package VTF\Db
 */
class Db implements IDb
{
	protected $connection = 'default';
	private $db = null;
	private $statement = null;
	private $params = array();
	private $bindParams = array();
	private $errors = array();
	public $sql;

	public function __construct($connection = null)
	{

		if ($connection instanceof \PDO) {
			$this->db = $connection;
		} else if ($connection != null) {
			$this->db = \VTF\App::getInstance()->getDbConnection($connection);
			$this->connection = $connection;
		} else {
			$this->db = \VTF\App::getInstance()->getDbConnection($this->connection);
		}
	}

	public function prepare($sql, $params = array(), $pdoOptions = array())
	{
		$this->errors = array();
		$this->statement = $this->db->prepare($sql, $pdoOptions);
		$this->params = $params;
		$this->sql = $sql;
		$this->bindParams = array();
		return $this;
	}

	public function execute($params = array())
	{
		if ($params != null && is_array($params) && count($params) > 0) {
			$this->params = $params;
		}

		if(count($this->params) > 0){
			try{
				return $this->statement->execute($this->params);
			}catch (\PDOException $ex){
				if(isset($ex->errorInfo) && isset($ex->errorInfo[2])) $this->errors[] = $ex->errorInfo[2];
			}
		}else{
			try{
				return $this->statement->execute();
			}catch (\PDOException $ex){
				if(isset($ex->errorInfo) && isset($ex->errorInfo[2])) $this->errors[] = $ex->errorInfo[2];
			}
		}

		return false;
	}

	public function bindParam($key, $value, $normalize = \PDO::PARAM_INT)
	{
		$this->statement->bindParam($key, $value, $normalize);
	}

	public function fetchAllAssoc()
	{
		return $this->statement->fetchAll(\PDO::FETCH_ASSOC);
	}

	public function fetchNum()
	{
		return $this->statement->fetch(\PDO::FETCH_NUM);
	}

	public function fetchColumn($column)
	{
		return $this->statement->fetchAll(\PDO::FETCH_COLUMN, $column);
	}

	public function fetchRowColumn($column)
	{
		return $this->statement->fetch(\PDO::FETCH_BOUND, $column);
	}

	public function getAffectedRows()
	{
		return $this->statement->rowCount();
	}

	public function getLastInserId()
	{
		return $this->db->lastInserId();
	}

	public function getStatement()
	{
		return $this->statement;
	}

	public function clearStatement(){
		$this->statement = null;
	}

	public function getErrors(){

		$out = '';
		foreach($this->errors as $error){
			$out.= '<h3>'.$error.'</h3>';
		}
		return $out;
	}
}