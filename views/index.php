<div id="albums-blk">
	<h2>Top rated Albums:</h2>
	<div id="albums-blk-items">
		<?php

		foreach ($this->albums as $album){

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
		}

		?>
	</div>
</div>


<div id="publicphotos">
	<h1>Latest photos:</h1>
	<div id="p-albums-items">
<?php

if(is_array($this->photos)) {
	foreach ($this->photos as $photo) {
		print '
		<div class="p-photos-block">
			<a href="/photo/view/' . $photo['phid'] . '/" class="aimgi">
				<img src="/photos/' . $photo['uid'] . '/t_' . $photo['filename'] . '" alt="' . $photo['name'] . '"/>
			</a>
			<div class="p-photos-inf">
				<strong class="p-photos-name">' . $photo['name'] . '</strong>
				<strong class="p-photos-author">from Album (<a href="/album/view/' . $photo['aid'] . '/" >link</a>)</strong>
				<em class="p-photos-date">' . substr($photo['created'], 0, 10) . '</em>
			</div>
		</div>';
	}
}
?>
	</div>
</div>