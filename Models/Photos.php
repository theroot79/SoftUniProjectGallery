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

	/**
	 * Get a list of photos based on album ID
	 *
	 * @param int $aid
	 * @param int $uid
	 * @return bool
	 */
	public function getPhotosByAlbum($aid, $uid = 0)
	{
		if($uid == 0){
			$sql = "SELECT * FROM `photos` WHERE `aid` = :aid ORDER BY `phid` DESC";
		}else{
			$sql = "SELECT * FROM `photos` WHERE `aid` = :aid AND `uid` = :uid ORDER BY `phid` DESC";
		}
		$q = $this->prepare($sql);
		$q->bindParam(':aid', $aid);
		if($uid != 0)$q->bindParam(':uid', $uid);
		$q->execute();

		$result = $q->fetchAllAssoc();

		if(count($result) > 0){
			return $result;
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
	public function addPhoto($uid, $aid, $name, $inputFiles)
	{
		$inpath='../public/photos/'.$uid;

		if(!is_dir($inpath)){
			@mkdir($inpath, 0777);@chmod($inpath, 0777);
		}

		$fileout = $this->uniqstr().'.jpg';
		$thumb = $this->makeThumbnail($inputFiles['file']['tmp_name'],$inpath.'/'.$fileout, 784, 588, 1);
		if($thumb != false){

			$q = $this->prepare("INSERT INTO `photos` (`uid`,`aid`,`name`,`filename`,`created`)
								VALUES (:uid,:aid,:name,:filename,NOW()) ");
			$q->bindParam(':uid', $uid);
			$q->bindParam(':aid', $aid);
			$q->bindParam(':name',$name, \PDO::PARAM_STR);
			$q->bindParam(':filename',$fileout, \PDO::PARAM_STR);
			$q->execute();
			$result = $q->getAffectedRows();
			if($result >= 0) {
				$this->makeThumbnail($inpath.'/'.$fileout, $inpath.'/t_'.$fileout, 204, 153, 1);

				return $result;
			}
		}

		return false;
	}

	public function delPhoto($uid, $phid)
	{
		$inpath = '../public/photos/' . $uid;

		$sql = "SELECT * FROM `photos` WHERE `phid` = :phid AND `uid` = :uid ";

		$q = $this->prepare($sql);
		$q->bindParam(':phid', $phid);
		$q->bindParam(':uid', $uid);
		$q->execute();

		$photo = $q->fetchAllAssoc();

		if ($photo && count($photo) > 0) {
			$photo = $photo[0];

			$q = $this->prepare("DELETE FROM `photos` WHERE `phid` = :phid");
			$q->bindParam(':phid', $photo['phid']);
			$q->execute();
			$result = $q->getAffectedRows();
			if ($result >= 0) {
				@unlink($inpath.'/'.$photo['filename']);
				@unlink($inpath.'/t_'.$photo['filename']);
				return $photo['aid'];
			}
		}
		return false;
	}

	/**
	 * Generate unique string.
	 *
	 * @param int $len
	 * @return mixed|string
	 */
	private function uniqstr($len = 15)
	{
		$ukey=crypt((microtime()+mt_rand(0, 100000)));
		$ukey=str_replace('$1$', '', $ukey);
		$ukey=strtolower(substr(preg_replace('/[^A-Za-z1-9]/', '', $ukey), 0, $len));
		return $ukey;
	}

	/**
	 * Function to create thumbnail from large image.
	 *
	 * @param $file
	 * @param $outfile
	 * @param $w_in
	 * @param $h_in
	 * @param int $crop_inside
	 * @param int $bgR
	 * @param int $bgG
	 * @param int $bgB
	 * @return bool
	 */
	private function makeThumbnail($file, $outfile, $w_in, $h_in, $crop_inside=0, $bgR=255, $bgG=255, $bgB=255)
	{

		list($in_width, $in_height, $type)=getimagesize($file);

		switch($type){
			case 1:
				$in_jpg=imagecreatefromgif($file);
				break;
			case 2:
				$in_jpg=imagecreatefromjpeg($file);
				break;
			case 3:
				$in_jpg=imagecreatefrompng($file);
				break;
			default:
				return false;
		}

		$image_new=imagecreatetruecolor($w_in, $h_in) or die("Проблеми с 'GD2'");
		if($type==2){
			for($y=0; $y<$h_in; $y++){
				for($x=0; $x<$w_in; $x++){
					imagesetpixel($image_new, $x, $y, imagecolorallocate($image_new, $bgR, $bgG, $bgB));
				}
			}
		}else{
			imagecolortransparent($image_new, '');
		}

		if($crop_inside==0){

			if(($in_width/$in_height)>($w_in/$h_in)){
				$h_in=$in_height/($in_width/$w_in);
			}else{
				$w_in=$in_width/($in_height/$h_in);
			}

			if(($in_width/$in_height)>=1.34){
				$pos_total=($w_in/2)-(($in_width/($in_height/$h_in))/2);
			}elseif((($in_width/$in_height)<1.333) and (($in_width/$in_height)>1) and ($h_in>100)){
				$pos_total=($w_in/2)-(($in_width/($in_height/$h_in))/2);
			}elseif((($in_width/$in_height)<1.333) and (($in_width/$in_height)>1) and ($h_in<100)){
				$pos_total=(($w_in/2)-(($in_width/($in_height/$h_in))/2))+1;
			}elseif(($in_width/$in_height)<1){
				$pos_total=($w_in/2)-(($in_width/($in_height/$h_in))/2);
			}elseif(($in_width/$in_height)==1){
				$pos_total=($w_in/2)-(($in_width/($in_height/$h_in))/2);
			}else{
				$pos_total=0;
			}

			imagecopyresampled($image_new, $in_jpg, $pos_total, 0, 0, 0, $w_in, $h_in, $in_width, $in_height);

		}else{
			if(($in_width/$in_height)>($w_in/$h_in)){
				$in_width=$in_height*($w_in/$h_in);
			}else{
				$in_height=$in_width/($w_in/$h_in);
			}

			imagecopyresampled($image_new, $in_jpg, 0, 0, 0, 0, $w_in, $h_in, $in_width, $in_height);
		}

		imagejpeg($image_new, $outfile, 100);
		imagedestroy($image_new);

		return true;
	}

}