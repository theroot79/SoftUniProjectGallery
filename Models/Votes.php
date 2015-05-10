<?php

namespace Models;

class Votes extends Main
{

	/**
	 * Add like / dislike
	 *
	 * @param int $aid
	 * @param int $likes
	 * @param int $dislikes
	 * @return bool
	 */
	public function addLikeDislike($aid = 0, $likes = 0, $dislikes = 0 )
	{
		$ip = ip2long($_SERVER['REMOTE_ADDR']);

		$q = $this->prepare("INSERT INTO `votes` (`aid`,`ip`,`likes`,`dislikes`) VALUES (:aid,:ip,:likes,:dislikes) ");
		$q->bindParam(':aid', $aid);
		$q->bindParam(':ip', $ip);
		$q->bindParam(':likes', $likes);
		$q->bindParam(':dislikes', $dislikes);
		$q->execute();
		$result = $q->getAffectedRows();
		if(count($result) > 0){
			return $result;
		}

		return false;
	}
}