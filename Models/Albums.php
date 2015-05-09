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
	public function getLatestAlbums()
	{
		$q = $this->prepare("SELECT *,
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
						FROM `albums` ORDER BY `alllikes` DESC,`alldislikes` ASC,`aid` DESC LIMIT :page, :offset ");
		$q->bindParam(':page', $this->getPage());
		$q->bindParam(':offset',$this::resultsPerPage);
		$q->execute();

		$result = $q->fetchAllAssoc();

		if(count($result) > 0){
			return $result;
		}

		return false;
	}
}