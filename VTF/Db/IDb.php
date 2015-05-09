<?php

namespace VTF\Db;

interface IDb
{
	public function prepare($sql, $params = array(), $pdoOptions = array());

	public function execute($params = array());

	public function bindParam($key, $value, $normalize = \PDO::PARAM_INT);

	public function fetchAllAssoc();

	public function getStatement();
}