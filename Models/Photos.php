<?php

namespace Models;

class Photos extends Main
{
	/**
	 * Returns the number of existing photos
	 *
	 * @return int|mixed
	 */
	public function getTotalPhotos()
	{
		$this->prepare('SELECT * FROM `photos` ')->execute();
		return $this->getAffectedRows();
	}

	/**
	 * Get a list of the most recent Photos
	 *
	 * @return Array|bool
	 */
	public function getLatestPhotos()
	{
		$q = $this->prepare("SELECT * FROM `photos` ORDER BY `phid` DESC LIMIT :page, :offset ");
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