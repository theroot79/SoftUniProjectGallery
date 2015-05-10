<?php

namespace Models;

class Categories extends Main
{

	/**
	 * Get a list of all categories
	 *
	 * @param string $orderBy Order by specific field
	 * @param string $direction Direction of order
	 * @return bool
	 */
	public function getAllCategories($orderBy = 'name', $direction = 'ASC')
	{
		$q = $this->prepare("SELECT * FROM `categories` ORDER BY :orderby {$direction}");
		$q->bindParam(':orderby',$orderBy,\PDO::PARAM_STR);
		$q->execute();
		$result = $q->fetchAllAssoc();

		if(count($result) > 0){
			return $result;
		}
		return false;
	}

	/**
	 * Procedure - add category.
	 *
	 * @param int $uid
	 * @param $name
	 * @return bool
	 */
	public function addCategory($uid = 0, $name)
	{
		$q = $this->prepare("INSERT INTO `categories` (`uid`,`name`) VALUES (:uid,:name) ");
		$q->bindParam(':uid', $uid);
		$q->bindParam(':name',$name, \PDO::PARAM_STR);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result >= 0) {
			return $result;
		}else{
			return false;
		}
	}


	/**
	 * Edits category.
	 *
	 * @param int $cid
	 * @param $name
	 * @return bool
	 */
	public function editCategory($cid = 0, $name)
	{
		$q = $this->prepare("UPDATE `categories` SET `name`=:name WHERE `cid`=:cid ");
		$q->bindParam(':name',$name, \PDO::PARAM_STR);
		$q->bindParam(':cid', $cid);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result >= 0) {
			return $result;
		}else{
			return false;
		}
	}

	/**
	 * Delete category.
	 *
	 * @param int $cid
	 * @return bool
	 */
	public function delCategory($cid = 0)
	{
		$q = $this->prepare("DELETE FROM `categories` WHERE `cid`=:cid ");
		$q->bindParam(':cid', $cid);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result >= 0) {
			return $result;
		}else{
			return false;
		}
	}
}