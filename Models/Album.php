<?php

namespace Models;

class Album extends Main {

	public function smallAlbumBlock($searchID=0,$aid=0,$uid=0,$photo='',$name='',$created=0,$likes=0,$dislikes=0,$comments=0){

		if($searchID < 1) {
			throw new \Exception('Wrong Album ID:'.$searchID, 500);
		}

		return $album;
	}

}