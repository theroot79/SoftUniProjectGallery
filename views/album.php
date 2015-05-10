<div id="albums-blk">
	<h2>Album: <?php print $this->album['name'];?></h2>
</div>

<div id="view-album">
	<div id="view-album-blk">
		<?php
		if($this->photos && is_array($this->photos) && count($this->photos) > 0) {
			$n = 0;
			foreach ($this->photos as $photo) {
				print '<img src="/photos/' . $photo['uid'] . '/t_' . $photo['filename'] . '" alt="' . $photo['name'] . '"/>';
				$n++;
				if($n > 3) break;
			}
		}
		?>
	</div>

	<div id="show-votes">
		<div id="vote-block">
			<h2 id="vote-block-title">Like this album:</h2>
			<form method="post" action="?" name="like" id="likeForm">
				<button type="submit" id="like"><?php print $this->album['alllikes'];?></button>
				<input type="hidden" name="action" value="like"/>
			</form>
			<form method="post" action="?" name="dislike" id="dislikeForm">
				<button type="submit" id="dislike"><?php print $this->album['alldislikes'];?></button>
				<input type="hidden" name="action" value="dislike"/>
			</form>
		</div>
	</div>

	<div id="comment-block">
		<h2 id="comment-block-title">Add Comments:</h2>
		<form method="post" action="?#comment-block">
			<p><input type="text" name="name" id="comment-uname" value="" placeholder="Your Name..." required="required"/></p>
			<p><textarea name="comment" placeholder="Write a comment..." id="comment-text" required="required"></textarea></p>
			<p class="captcha">
				<button type="submit" id="comment-button">Comment</button>
			</p>
			<p class="submitbtn">
			<input type="hidden" name="action" value="addcomment"/>
		</form>
	</div>

	<?php
	if($this->comments && is_array($this->comments) && count($this->comments) > 0){

		print '
		<div id="comment-list">';

		foreach($this->comments as $comment){
			print '
			<div class="full-comment">
				<strong class="full-comment-name">'.$comment['name'].':</strong>
				<em class="full-comment-date">'.$comment['created'].'</em>

				<div class="full-comment-comment">'.$comment['comment'].'</div>
			</div>';

		}
		print '
		</div>';
	}


	?>

</div>

