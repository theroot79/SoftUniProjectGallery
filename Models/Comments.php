<?php

namespace Models;

class Comments extends Main
{

	/**
	 * Get comments for an item
	 *
	 * @param int $aid
	 * @param int $phid
	 * @return bool
	 */
	public function getComments($aid = 0, $phid = 0)
	{
		$q = $this->prepare("SELECT * FROM `comments` WHERE `aid` = :aid AND `phid` = :phid ORDER BY `created` DESC ");
		$q->bindParam(':aid', $aid);
		$q->bindParam(':phid', $phid);
		$q->execute();
		$result = $q->fetchAllAssoc();
		if(count($result) > 0){
			return $result;
		}

		return false;
	}


	/**
	 * Add comment
	 *
	 * @param int $aid
	 * @param int $phid
	 * @param string $name
	 * @param string $comment
	 * @return bool
	 */
	public function addComments($aid = 0, $phid = 0, $name, $comment)
	{
		$q = $this->prepare("INSERT INTO `comments` (`aid`,`phid`,`name`,`comment`,`created`)
							VALUES (:aid,:phid,:name,:comment,NOW()) ");
		$q->bindParam(':aid', $aid);
		$q->bindParam(':phid', $phid);
		$q->bindParam(':name',$name, \PDO::PARAM_STR);
		$q->bindParam(':comment',$comment, \PDO::PARAM_STR);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result >= 0) {
			return $result;
		}
		return false;
	}

}