<div id="new-album-category">
	<div id="new-album-form">
		<h1>Confirm album &rdquo;<?php print $this->album['name'];?>&rdquo; deletion</h1>
		<form method="post" class="frm">
			<p style="color:white">All photos related to the album - will be deleted!</p><br/>
			<button type="submit" name="submit">Delete now !</button>
			<input type="hidden" name="action" value="delalbum"/>
		</form>
	</div>
</div>