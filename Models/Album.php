<?php

namespace Models;

class Album extends Main {

	public function smallAlbumBlock($searchID=0,$aid=0,$uid=0,$photo='',$name='',$created=0,$likes=0,$dislikes=0,$comments=0){

		if($searchID < 1) {
			throw new \Exception('Wrong Album ID:'.$searchID, 500);
		}

		$q = $this->prepare("SELECT *,
		             IFNULL(
		                (SELECT `filename` FROM `photos` WHERE `photos`.`aid`=`albums`.`aid`
		                    ORDER BY `phid` DESC LIMIT 1), '') AS `photo`
						FROM `albums` WHERE `aid`= :aid ");
		$q->bindParam(':aid', $searchID);
		$q->execute();
		$album = $this->fetchAllAssoc();

		if(count($album) > 0){
			foreach($album as $item){
				$aid=$item['aid'];
				$uid=$item['uid'];
				$photo=$item['photo'];
				$name=$item['name'];
				$created=$item['created'];
			}
		}

		$image='/assets/img/no-image.jpg';
		if(!empty($photo))
			$image='/photos/'.$uid.'/t_'.$photo;

		return $result;
	}

}