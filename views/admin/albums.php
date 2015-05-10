<div class="admin-table">
	<?php

	if($this->albums && is_array($this->albums) && count($this->albums) > 0){

		print '
		<table border="1" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<th>Album ID:</th>
				<th>Name:</th>
				<th>Category:</th>
				<th>By User:</th>
				<th>Action</th>
			</tr>';

		foreach($this->albums as $album){
			print '
			<tr>
				<td>'.$album['aid'].'</td>
				<td>
					<form method="post">
						<input type="text" name="name" value="'.$album['name'].'" required="required"/>
						<button type="submit" name="action" value="editname">EDIT</button>
						<input type="hidden" name="albumid" value="'.$album['aid'].'"/>
						<input type="hidden" name="oldname" value="'.$album['name'].'"/>
						<input type="hidden" name="cat" value="'.$album['cid'].'"/>
					</form>
				</td>
				<td>'.$album['category'].'</td>
				<td>'.$album['user'].'</td>
				<td>
					<a href="/admin/albums/del/'.$album['aid'].'">Delete</a>
				</td>
			</tr>';
		}

		print '
		</table>';
	}
	?>
</div>
<div class="admin-table">
	<h2>Create new album:</h2>
	<form method="post" class="frm">
		<select name="category">
			<?php
			foreach($this->categories as $category){
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