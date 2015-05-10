<div id="viewphoto">
	<h1 class="viewphoto-album-name"><?php print $this->photo['name'];?></h1>

	<div id="view-photo-blk">
		<div id="p-photos-block">
			<img src="/photos/<?php print $this->photo['uid'];?>/<?php print $this->photo['filename'];?>"
			     alt="<?php print $this->photo['name'];?>"/>
		</div>
	</div>
	<h2 id="p-photo-name"><a href="/album/view/<?php print $this->album['aid'];?>/">Album: <?php print $this->album['name'];?></a></h2>

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

