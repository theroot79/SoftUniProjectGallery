<div id="new-album-category">
	<div id="new-album-form">
		<h1>Edit album</h1>
		<form method="post" class="frm">
			<select name="category">
				<?php
				foreach($this->userCategories as $category) {
					$selected = '';
					if($this->album['cid'] == $category['cid'])$selected = ' selected="selected"';
					print '
					<option value="' . $category['cid'] . '" '.$selected.'>' . $category['name'] . '</option>';
				}
				?>
			</select>
			<input type="text" name="name" value="<?php print $this->album['name'];?>" placeholder="Album name" required="required"
			          maxlength="150" />
			<button type="submit" name="submit">Edit</button>
			<input type="hidden" name="action" value="editalbum"/>
		</form>
	</div>
</div>