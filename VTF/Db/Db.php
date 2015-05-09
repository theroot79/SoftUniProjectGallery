<?php

namespace VTF\Db;

/**
 * Database class
 *
 * Class Db
 * @package VTF\Db
 */
class Db
{
	protected $connection = 'default';
	private $db = null;
	private $statement = null;
	private $params = array();
	private $sql;

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

		$this->statement = $this->db->prepare($sql, $pdoOptions);
		$this->params = $params;
		$this->sql = $sql;
		return $this;
	}

	public function execute($params = array())
	{
		if ($params != null && is_array($params) && count($params) > 0) {
			$this->params = $params;
		}

		$this->statement->execute($this->params);
		return $this;
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
}