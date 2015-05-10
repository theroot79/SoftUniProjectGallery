<?php

namespace Models;

class Albums extends Main
{

	/**
	 * Returns the number of existing Albums
	 *
	 * @return int|mixed
	 */
	public function getTotalAlbums()
	{
		$this->prepare('SELECT * FROM `albums` ')->execute();
		return $this->getAffectedRows();
	}

	/**
	 * Get a list of the most recent Albums
	 *
	 * @return Array|bool
	 */
	public function getLatestAlbums($uid = 0)
	{
		$where = "";
		if($uid > 0){
			$where = " WHERE";
			$where .= " `uid`=:uid ";
		}

		$sql = "SELECT *,
		             IFNULL(
		                (SELECT `filename` FROM `photos` WHERE `photos`.`aid`=`albums`.`aid`
		                    ORDER BY `phid` DESC LIMIT 1), '') AS `photo`,
		             IFNULL(
		                (SELECT SUM(`likes`) as `alllikes` FROM `votes` WHERE `votes`.`aid`=`albums`.`aid`),'0')
		                	AS `alllikes`,
		             IFNULL(
		                (SELECT SUM(`dislikes`) as `alldislikes` FROM `votes` WHERE `votes`.`aid`=`albums`.`aid`),'0')
		                	AS `alldislikes`,
		             IFNULL(
		                (SELECT COUNT(`cid`) as `comments` FROM `comments` WHERE `comments`.`aid`=`albums`.`aid`),'0')
		                	AS `comments`
						FROM `albums` {$where} ORDER BY `alllikes` DESC,`alldislikes` ASC,`aid` DESC LIMIT :page, :offset ";



		$q = $this->prepare($sql);
		$q->bindParam(':page', $this->getPage());
		$q->bindParam(':offset',$this::resultsPerPage);
		if($uid > 0)$q->bindParam(':uid',$uid);

		$q->execute();

		$result = $q->fetchAllAssoc();

		if(count($result) > 0){
			return $result;
		}

		return false;
	}

	/**
	 * Returns single album data.
	 *
	 * @param int $aid
	 * @return bool
	 */
	public function getAlbumData($aid = 0)
	{
		$sql = "SELECT *,
		             IFNULL(
		                (SELECT `filename` FROM `photos` WHERE `photos`.`aid`=`albums`.`aid`
		                    ORDER BY `phid` DESC LIMIT 1), '') AS `photo`,
		             IFNULL(
		                (SELECT SUM(`likes`) as `alllikes` FROM `votes` WHERE `votes`.`aid`=`albums`.`aid`),'0')
		                	AS `alllikes`,
		             IFNULL(
		                (SELECT SUM(`dislikes`) as `alldislikes` FROM `votes` WHERE `votes`.`aid`=`albums`.`aid`),'0')
		                	AS `alldislikes`,
		             IFNULL(
		                (SELECT COUNT(`cid`) as `comments` FROM `comments` WHERE `comments`.`aid`=`albums`.`aid`),'0')
		                	AS `comments`
						FROM `albums` WHERE `aid` = :aid ";

		$q = $this->prepare($sql);
		$q->bindParam(':aid', $aid);
		$q->execute();

		$result = $q->fetchAllAssoc();

		if(count($result) > 0){
			return $result[0];
		}

		return false;
	}

	/**
	 * Add new album procedure
	 *
	 * @param int $uid
	 * @param $name
	 * @return bool
	 */
	public function addAlbum($uid = 0, $name)
	{
		$q = $this->prepare("INSERT INTO `albums` (`uid`,`name`,`created`) VALUES (:uid,:name,NOW()) ");
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
	 * Edit album procedure.
	 *
	 * @param int $aid
	 * @param int $catId
	 * @param $name
	 * @param $oldname
	 * @return bool
	 */
	public function editAlbum($aid = 0, $catId = 1, $name, $oldname)
	{
		if($name == $oldname){
			$sql = "UPDATE `albums` SET `cid` = :catid WHERE `aid` = :aid";
		}else{
			$sql = "UPDATE `albums` SET `name` = :name, `cid` = :catid WHERE `aid` = :aid";
		}
		$q = $this->prepare($sql);
		if($name != $oldname)$q->bindParam(':name',$name, \PDO::PARAM_STR);
		$q->bindParam(':catid', $catId);
		$q->bindParam(':aid', $aid);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result >= 0) {
			return $result;
		}else{
			return false;
		}
	}

	/**
	 * Del album procedure.
	 *
	 * @param int $aid
	 * @param array $user
	 * @return bool
	 */
	public function delAlbum($aid = 0, $user = array())
	{
		if($user['role'] == 'admin'){
			$sql = "DELETE FROM `albums` WHERE `aid` = :aid";
		}else{
			$sql = "DELETE FROM `albums` WHERE `aid` = :aid AND `uid` = :uid";
		}
		$q = $this->prepare($sql);
		$q->bindParam(':aid', $aid);
		if($user['role'] != 'admin')$q->bindParam(':uid', $user['uid']);
		$q->execute();
		$result = $q->getAffectedRows();
		if($result >= 0) {
			return $result;
		}else{
			return false;
		}
	}
}