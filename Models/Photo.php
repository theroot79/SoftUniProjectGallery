<?php

namespace Models;

class Photo extends Main {

	public function smallPhotoBlock($searchID=0, $phid=0, $uid=0, $filename='', $name='', $created=0 ,$aid=0){

		if($searchID < 1) {
			throw new \Exception('Wrong Photo ID:'.$searchID, 500);
		}

		$q = $this->prepare("SELECT * FROM `photos` WHERE `phid`= :phid ");
		$q->bindParam(':phid', $searchID);
		$q->execute();
		$photo = $this->fetchAllAssoc();

		if(count($photo) > 0){
			foreach($photo as $item){
				$phid=$item['phid'];
				$uid=$item['uid'];
				$aid=$item['aid'];
				$filename=$item['filename'];
				$name=$item['name'];
				$created=$item['created'];
			}
		}

		$result='
		<div class="p-photos-block">
				<a href="/photo/'.$phid.'/" class="aimgi">
					<img src="/photos/'.$uid.'/t_'.$filename.'" alt="'.$name.'"/>
				</a>
				<div class="p-photos-inf">
					<strong class="p-photos-name">'.$name.'</strong>
					<strong class="p-photos-author">by Author (<a href="/album/'.$aid.'/" >link</a>)</strong>
					<em class="p-photos-date">'.substr($created,0,10).'</em>
				</div>
			</div>';

		return $result;
	}

}