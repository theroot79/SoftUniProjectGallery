<div id="add-photo">

	<div id="add-photo-form">
		<h2>Upload new photo</h2>
		<form method="post" class="frm" enctype="multipart/form-data">
			<p><input type="file" name="file" value="" required="required" accept="image/*"/>
				<input type="text" name="name" value="" placeholder="Photo name"
				       required="required" maxlength="150" /></p>
			<p><button type="submit" name="submit">Upload now</button></p>
			<input type="hidden" name="action" value="addfile"/>
		</form>
	</div>
</div>
<div id="photos-manage-blk">
	<h2>Your photos in the album</h2>
	<div id="photos-manage-items">
		<?php
		if($this->userPhotos && is_array($this->userPhotos) && count($this->userPhotos) > 0){
			foreach($this->userPhotos as $photo){
				print '<div class="photos-manage-block">
					<a href="/photos/'.$photo['uid'].'/'.$photo['filename'].'" class="aimgi" target="_blank">
						<img src="/photos/'.$photo['uid'].'/t_'.$photo['filename'].'" alt="'.$photo['name'].'"/>
					</a>
					<div class="photos-manage-btns">
						<strong>'.$photo['name'].'</strong>
						<a href="/myphotos/del/90/">delete</a>
					</div>
				</div>';
			}
		}
		?>
	</div>
</div>