<div id="albums-blk">
	<h1>Categories and albums:</h1>
	<div id="albums-blk-items">
<?php

if($this->categories && count($this->categories) > 0){

	foreach($this->categories as $category){



		if(isset($this->albums[$category['cid']]) && is_array($this->albums[$category['cid']]) && count($this->albums[$category['cid']]) > 0){

			print '<h2><a href="/categories/view/'.$category['cid'].'">'.$category['name'].'</a></h2>';

			$albums = $this->albums[$category['cid']];

			$n = 0;
			foreach($albums as $album){

				$photo = '/assets/img/no-image.jpg';
				if(!empty($album['photo']))$photo = '/photos/'.$album['uid'].'/t_'.$album['photo'];

				print '
				<div class="album-block">
					<a href="/album/view/'.$album['aid'].'/" class="aimgi">
						<img src="'.$photo.'" alt="'.$album['name'].'"/>
					</a>
					<div class="albums-inf">
						<strong>'.$album['name'].'</strong>
					</div>
					<div class="albums-likes">
						<strong class="likesnum">Likes: '.$album['alllikes'].'</strong>
						<strong class="dislikesnum">Dislikes: '.$album['alldislikes'].'</strong>
						<strong class="commentsnum">Comments: '.$album['comments'].'</strong>
					</div>
				</div>';
				$n++;
				if($n > 3)break;
			}
		}
	}


}else{
	print '<h1>Nothing to show !</h1>';
}

?>
	</div>
</div>