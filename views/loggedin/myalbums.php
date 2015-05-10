<div id="new-album-category">
	<div id="new-album-form">
		<h1>Add new album?</h1>
		<form method="post" action="/myalbums/" class="frm">
			<select name="category">
				<?php
				foreach($this->userCategories as $category){
					print '
					<option value="'.$category['cid'].'">'.$category['name'].'</option>';
				}
				?>
			</select>
			<input type="text" name="name" value="" placeholder="Album name" required="required"
			          maxlength="150" />
			<button type="submit" name="submit">Add</button>
			<input type="hidden" name="action" value="addalbum"/>
		</form>
	</div>
	<?php

	if($this->user && $this->user['role'] == 'admin'){
		print '
		<div id="new-category-form">
			<h1>Manage categories ?</h1>
			<form method="post" action="/myalbums/" class="frm">
				<select name="category" id="category-dropdown">
					<option value="0">  </option>
					<option value="999999"> ------------------ Add new category -----------------</option>';

					foreach($this->userCategories as $category){
						print '
					<option value="'.$category['cid'].'"> EDIT: '.$category['name'].'</option>';
					}

		print '
				</select>
				<input type="text" name="name" value="" id="cat-name-field" />
				<button type="submit" name="submit" id="cat-add-btn">Add</button>
				<button type="submit" name="submit" id="cat-edit-btn">Edit</button>
				<button type="submit" name="submit" id="cat-del-btn">Del</button>
				<input type="hidden" name="action" id="cat-action" value="add"/>
			</form>
		</div>';
	}
	?>
</div>


<div id="albums-manage-blk">
	<h2>Your albums:</h2>
	<div id="albums-manage-items">
		<?php

if($this->userAlbums && count($this->userAlbums) > 0){

	foreach($this->userAlbums as $album){

		$photo = '/assets/img/no-image.jpg';
		if(!empty($album['photo']))$photo = '/photos/'.$album['uid'].'/t_'.$album['photo'];

		print '
		<div class="album-manage-block">
			<a href="/myphotos/viewalbum/'.$album['aid'].'/" class="aimgi">
				<img src="'.$photo.'" alt="'.$album['name'].'"/>
			</a>
			<div class="album-manage-btns">
				<strong>'.$album['name'].'</strong>
				<a href="/myalbums/edit/'.$album['aid'].'/">edit</a>
				<a href="/myalbums/del/'.$album['aid'].'/">del</a>
			</div>
		</div>';
	}
}
		?>
	</div>
</div>