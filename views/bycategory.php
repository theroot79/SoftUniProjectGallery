<div id="albums-blk">
	<h1>Category: <?php print $this->category['name'];?></h1>
	<div id="albums-blk-items">
<?php

if($this->albums && is_array($this->albums) && count($this->albums) > 0){
	foreach($this->albums as $album) {

		$photo = '/assets/img/no-image.jpg';
		if (!empty($album['photo'])) $photo = '/photos/' . $album['uid'] . '/t_' . $album['photo'];

		print '
		<div class="album-block">
			<a href="/album/view/' . $album['aid'] . '/" class="aimgi">
				<img src="' . $photo . '" alt="' . $album['name'] . '"/>
			</a>
			<div class="albums-inf">
				<strong>' . $album['name'] . '</strong>
			</div>
			<div class="albums-likes">
				<strong class="likesnum">Likes: ' . $album['alllikes'] . '</strong>
				<strong class="dislikesnum">Dislikes: ' . $album['alldislikes'] . '</strong>
				<strong class="commentsnum">Comments: ' . $album['comments'] . '</strong>
			</div>
		</div>';
	}
}else{
	print '<div>No albums in this category!</div>';
}


?>
	</div>

	<?php
	if($this->albums && is_array($this->albums) && count($this->albums) > 0){
		print $this->paging;
	}
	?>
</div>